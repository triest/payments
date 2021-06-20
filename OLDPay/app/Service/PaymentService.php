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

        $order=Order::find($input['order_id']);

        if (!$order) {
            return (['result' => false, 'message' => ['order_id' => ['Заказ не найден']]]);
        }


        $payment=new Payments();

        $payment->name=$input['name'];
        $payment->sum=$input['sum'];
        $payment->order_id=$input['order_id'];
        $payment->save();
        $order->paid=1;
        $order->status_id=2;
        $order->save();
        $user=$order->user()->first();
        if(!$user){
            return (['result' => false, 'message' => ['user' => ['Пользователь не найлен']]]);
        }
        $user->balance+=$payment->sum;

        $user->save();

        return (['result'=>true,'data'=>['url'=>$order->url]]);
    }
}
