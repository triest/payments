<?php


namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private $url="http://xyz-payment.ru/pay";


    /*
     * симулируем оплату
     * */
    function pay($sum,$order_id,$name ){
        $client = new Client();
        try {
            $response = $client->get(
                    $this->url,
                    ['query' => ['sum' => $sum, 'order_id' => $order_id, 'transaction_id' => 1]]
            );

            return true;
        }catch (BadResponseException $exception){
            return false;
        }

    }


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
                    "http://xyz-payment.ru/input",
                    [
                            'form_params' => [
                                    'order_id' => $order_id,
                                    'transaction_id' => $transaction_id,
                                    'sum' =>$sum,
                                    'sign'=>config('app.secret_key')
                                       ]]
            );


        } catch (BadResponseException $e) {
            $message = $e->getMessage();
            return ['result' => false, 'message' => $message];
        }

        $temp=json_decode($result->getBody());

        $temp=json_decode(json_encode($temp),true);


        return ['result'=>true,'data'=>$temp];
    }

}
