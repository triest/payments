<?php


namespace App\Service;


use App\Models\Order;
use App\Models\Payments;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

class PaymentService
{
    public function pay($input ){


        $validator = Validator::make($input,[
                'name' => 'required',
                'sum' => 'required|numeric|min:0.01',
                'order_id' => 'required|exists:orders,id',
        ]);


        if ($validator->fails()) {
            return (['result'=>false,'message'=> $validator->messages()]);
        }


        $payment=new Payments();

        $payment->name=$input['name'];
        $payment->sum=$input['sum'];
        $payment->order_id=$input['order_id'];
        $payment->save();
        return (['result'=>true,'data'=>['url'=>"http://example.com"]]);
    }
}
