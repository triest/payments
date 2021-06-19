<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentStatusResource;
use App\Models\Payments;
use App\Service\PaymentService;
use Faker\Provider\ar_SA\Payment;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    //
    public function pay(Request $request){


        $validator = Validator::make($request->all(),[
                                                'name' => 'required',
                                                'sum' => 'required|numeric|min:0.01',
                                                'order_id' => 'required|exists:orders,id',
                                        ]);

        if ($validator->fails()) {
            return response()->json(['result'=>false,'message'=> $validator->messages()],422);
        }

        $payment_servise=new PaymentService();
         $result=$payment_servise->pay($request->toArray());
         if(!$result['result']){
             return response()->json(['result'=>false,'message'=> $result['messages']],422);
         }

        return response()->json(["status"=>"success", "redirect_to"=>"http://example.com"])->setStatusCode(202);
    }


    public function getStatus(Request $request){
        $validator = Validator::make($request->all(),[

                'id' => 'required|exists:payments,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['result'=>false,'message'=> $validator->messages()],422);
        }

        $payment=Payments::select(['*'])->with('status')->first();

        if (!$request->hasHeader('X-Secret-Key') || !config('app.secret_key') || $request->header('X-Secret-Key'
                ) != config('app.secret_key')) {
            //
            return response(['message'=>"Unauthenticated"])->setStatusCode(401);
        }


        if($payment) {
            return new PaymentStatusResource($payment);
        }else{
            return null;
        }
    }
}
