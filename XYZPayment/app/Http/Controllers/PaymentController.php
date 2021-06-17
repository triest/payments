<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentFormRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //
    public function form(PaymentFormRequest $request)
    {
        $payment = new Payment();
        $payment->order_id = Payment::max('id') ? Payment::max('id') : 1;
        $payment->name = $request->name;
        $payment->sum = $request->sum;
        $payment->save();
    }

    /*
     * эмуляция платежной системы
     * */
    public function pay(PaymentRequest $request)
    {

        $client = new Client(
                [
                        'headers' => [
                                'Content-Type' => 'application/json',
                        ]
                ]
        );
        try {
            $result = $client->request(
                    'POST',
                    "http://xyz-payment.ru/input",
                    [
                            'form_params' => [
                                    'field_name' => 'abc',
                                    'other_field' => '123',
                                    'nested_field' => [
                                            'nested' => 'hello'
                                    ]
                            ]                    ]
            );

            //  return response('',200);
        } catch (BadResponseException $e) {
            $message = $e->getMessage();
            return ['result' => false, 'message' => $message];
        }

           return response('ok',200);
    }

    /**
     * Store a new blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request){

         $payment=new Payment();

        // array check
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



        $payment->order_id=$request->order_id;
        $payment->transaction_id=$request->transaction_id;
        $payment->sum=$request->sum;
        $payment->save();

        $order=$payment->order()->first();
        if(!$order){
            Log::error("order not found");
            Log::debug(print_r($request->post()));
            return \response()->setStatusCode(405);
        }

        $user=$order->user()->first();


        $user->balance+=$payment->sum;
        $user->save();


        return response(null)->setStatusCode(202);
    }
}
