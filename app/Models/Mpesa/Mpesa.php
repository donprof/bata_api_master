<?php

namespace App\Models\Mpesa;

use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    protected $fillable = [
        'address_id',
        'payment_method_id',
        'shipping_method_id',
        'user_id',
        'order_id',
        'amount',
        'mpesareceiptnumber',
        'transactiondate',
        'phonenumber',
    ];
}
