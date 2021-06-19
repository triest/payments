<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentFormRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Service\PaymentService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{


    public function __construct()
    {

        $this->client = new Client(
                [
                        'headers' => [
                                'Content-Type' => 'application/json',

                        ]
                ]
        );


    }



    public function form(){
       $order=Order::select(['id'])->where(['paid'=>0])->
       first();

        return view('form')->with(['order_id'=>$order->id]);
    }
    //
    public function sendPay(PaymentFormRequest $request)
    {
        $payment = new Payment();
        $payment->order_id = Payment::max('id') ? Payment::max('id') : 1;
        $payment->name = $request->name;
        $payment->sum = $request->sum;
        $payment->save();

        $paymentService=new PaymentService();
        $result=$paymentService->pay($payment->sum,$payment->order_id,$payment->name);
        if($result) {
            return redirect()->back()->with('message', 'PaymentSend!');
        }else{
            return redirect()->back()->with('error', 'Payment error!');
        }
    }

    /*
     * эмуляция платежной системы
     * */
    public function pay(Request $request)
    {
        $validator = Validator::make(
                $request->all(),
                [
                        'order_id' => 'required|exists:orders,id',
                        'transaction_id' => 'required|numeric',
                        'sum' => 'required|numeric|min:0',
                ]
        );


        if($validator->fails()){
            $messages=$validator->messages();
            return response($messages,422);
        }

        $paymentService=new PaymentService();
        $result=$paymentService->sendResponse($request['order_id'],$request['transaction_id'],$request['sum']);


        if($result['result']) {
            return \response([], 202);
        }else{
            return \response($result['message'],422);
        }
    }

    /**
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request)
    {
        $payment = new Payment();

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
            return response($messages, 422);
        }


        Log::debug($request->sign);
        Log::debug(config('app.secret_key'));

        if ($request->sign != config('app.secret_key')) {
            return \response(['errors' => "wrong_secret_key"], 422);
        }

        $payment->order_id = $request->order_id;
        $payment->transaction_id = $request->transaction_id;
        $payment->sum = $request->sum;
        $payment->save();

        $order = $payment->order()->first();
        if (!$order) {
            Log::error("order not found");
            Log::debug(print_r($request->post()));
            return \response()->setStatusCode(405);
        }

        $user = $order->user()->first();


        $user->balance += $payment->sum;
        $user->save();


        return response(
                [
                        'order_id' => $payment->order_id,
                        "name" => "name",
                        'transaction_id' => $payment->transaction_id,
                        'secret_key' => config('app.secret_key')
                ]
        )->setStatusCode(202);
    }
}
