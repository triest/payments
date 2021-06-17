<?php


namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private $url="https://xyz-payment.ru/pay";

    function pay($sum,$order_id,$name ){
        $client = new Client();
        try {
            $response = $client->get($this->url, ['sum' => $sum, 'order_id' => $order_id, 'name' => $name]);
        }catch (BadResponseException $exception){
            Log::error($this->url);
            Log::error($exception->getMessage());
            return false;
        }
        return true;
    }

}
