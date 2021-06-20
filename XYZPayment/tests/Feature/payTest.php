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
      $order=Order::factory()->count(1)
                ->create();


      $user=User::factory()->count(1)->create();

      $payment=new Payment();
      $payment->order_id=$order[0]->id;
      $payment->name="ds";
      $payment->sum=50;
      $payment->save();


        $array=['_token' => csrf_token(),
                'sum'=>200,
                'order_id'=>$order[0]->id];

        $response = $this->post('/form',$array);

        $response->assertStatus(302);
    }


}
