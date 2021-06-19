<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payments;

class PaymentStatus extends Model
{
    use HasFactory;

    public function payments(){
        return $this->hasOne(Payments::class);
    }
}
