<?php


namespace App\Service;


use App\Models\Order;
use App\Models\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

class PaymentService
{
    private $url = "http://old-pay.ru/api/create";

    public function pay($input)
    {
        $client = new Client(
        );
        try {
            $result = $client->request(
                    'POST',
                    $this->url,
                    [
                            'form_params' => [
                                    'order_id' => $input['order_id'],
                                    'transaction_id' =>  $input['transaction_id'],
                                    'sum' => $input['sum'],
                                    'sign' => config('app.secret_key')
                            ]
                    ]
            );
            return ['result' => true, 'data' => $result->getBody()];
        } catch (BadResponseException $e) {
            $message = $e->getMessage();
            return ['result' => false, 'message' => $message];
        }
    }

    /*ответ от плалежной систнмы*/
    public function sendResponse($order_id,$transaction_id,$sum){

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
                    "http://old-pay.ru/input",
                    [
                            'form_params' => [
                                    'order_id' => $order_id,
                                    'transaction_id' => $transaction_id,
                                    'sum' =>$sum,
                                    'sign'=>config('app.secret_key')
                            ]]
            );
            $temp=$result->getBody();

            return ['result'=>true,'data'=>$temp];

        } catch (BadResponseException $e) {
            $message = $e->getMessage();
            Log::debug($e->getMessage());
            Log::debug($e->getCode());
            return ['result' => false, 'message' => $message];
        }


    }

}
