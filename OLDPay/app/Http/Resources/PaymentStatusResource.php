<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'status' => $this->order->status ? $this->order->status->name:null,
                'sum' => $this->sum ? $this->sum:null,
                'order_id' => $this->order_id ?? $this->order_id::null,
        ];
    }
}
