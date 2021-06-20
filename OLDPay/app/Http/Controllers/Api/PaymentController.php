<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentStatusResource;
use App\Models\Order;
use App\Models\Payment;
use App\Service\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //переход к орлате
    public function form(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                [
                        'name' => 'required',
                        'sum' => 'required|numeric|min:0.01',
                        'order_id' => 'required|exists:orders,id',
                ]
        );

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->messages()], 422);
        }

        $payment_service = new PaymentService();

        $result = $payment_service->pay($request->toArray());

        if (!$result['result']) {
            return response()->json(['result' => false, 'message' => $result['message']], 422);
        }

        return response()->json(["status" => "success", "redirect_to" => "http://example.com"])->setStatusCode(202);
    }


    public function getStatus(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                [

                        'id' => 'required|exists:payments,id',
                ]
        );

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->messages()], 422);
        }

        $payment = Payment::select(['*'])->where('id', $request->id)->with('status', 'order')->first();

        if (!$request->hasHeader('X-Secret-Key') || !config('app.secret_key') || $request->header(
                        'X-Secret-Key'
                ) != config('app.secret_key')) {
            //
            return response(['message' => "Unauthenticated"])->setStatusCode(401);
        }


        if ($payment) {
            return new PaymentStatusResource($payment);
        } else {
            return null;
        }
    }

    public function create(Request $request)
    {

        $validator = Validator::make(
                $request->all(),
                [
                        'order_id' => 'required|exists:orders,id',
                        'transaction_id' => 'required|numeric',
                        'sum' => 'required|numeric|min:0',
                ]
        );




        if ($validator->fails()) {
            $messages = $validator->messages();
            return response($messages, 422);
        }



        $paymentService = new PaymentService();
        $result = $paymentService->sendResponse($request['order_id'], $request['transaction_id'], $request['sum']);



        if ($result['result'] == true) {
            return \response()->json(['status' => "success", 'redirect_to' => "http://example.com"])->setStatusCode(
                    202
            );
        } else {
            return \response()->json(['status' => 'error', 'message' => $result['message']])->setStatusCode(422);
        }
    }


    public function input(Request $request)
    {
        // array check
        $validator = Validator::make(
                $request->all(),
                [
                        'order_id' => 'required|exists:orders,id',
                        'transaction_id' => 'required|numeric',
                        'sum' => 'required|numeric|min:0',
                        'sign' => 'required',
                ]
        );


        if ($validator->fails()) {
            $messages = $validator->messages();
            return \response()->json(['message'=>$messages])->setStatusCode(422);
        }



        if ($request->sign != config('app.secret_key')) {
            return response()->json(['message'=>"wrong secret key"]);

        }

        $order = Order::select()->where('id', $request->order_id)->first();
        if (!$order) {
            Log::error("order not found");
            Log::debug(print_r($request->post()));
            return \response([], 405);
        }

        $payment = new Payment();

        $payment->order_id = $request->order_id;
        $payment->transaction_id = $request->transaction_id;
        $payment->sum = $request->sum;
        $payment->save();


        $user = $order->user()->first();


        $user->balance += $payment->sum;
        $user->save();


        return response(
                [
                        'status' => 'success',
                        'sum' => $request->sum,
                        'order_id' => $request->order_id
                ],
                202
        );

    }
}
