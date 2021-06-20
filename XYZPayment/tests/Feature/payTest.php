<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class payTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_form()
    {
        $order = Order::factory()->count(1)
                ->create();


        $user = User::factory()->count(1)->create();

        $payment = new Payment();
        $payment->order_id = $order[0]->id;
        $payment->name = "ds";
        $payment->sum = 50;
        $payment->save();


        $array = [
                '_token' => csrf_token(),
                'sum' => 200,
                'order_id' => $order[0]->id
        ];

        $response = $this->post('/form', $array);

        $response->assertStatus(302);
    }

    public function test_validation_form_fail()
    {
        $array=[    '_token' => csrf_token()];
        $response = $this->get('/pay', $array);

        $response->assertStatus(422);
    }

    public function test_validation_form_success()
    {
        $order = Order::factory()->count(1)
                ->create();
        $array=[    '_token' => csrf_token(),
                'sum'=>100,
                'order'=> $order[0]->id];
        $response = $this->get('/pay', $array);

        $response->assertStatus(422);
    }

    public function test_input_validtion_fail()
    {
        $response=$this->post('input');

        Log::debug($response->getStatusCode());

        $response->assertStatus(422);
    }

    public function test_input(){

        $user=User::factory()->count(1)->create();
        $user=$user[0];

        $order = Order::factory()->count(1)
                ->create();

        $user=$order->user()->first();
        $balance=$user->balance;


        $response=$this->post('input',['order_id'=>$order[0]->id,'transaction_id'=>1,'sum'=>10,'sign'=>config('app.secret_key')]);

        $new_user=User::select(['balance'])->where(['id'=>$user->id])->first();

        self::assertEquals($new_user->balance,$balance+10);

     //   $response->assertStatus(202);
    }
}
