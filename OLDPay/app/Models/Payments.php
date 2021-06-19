<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    public function status(){
        return $this->belongsTo(PaymentStatus::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
