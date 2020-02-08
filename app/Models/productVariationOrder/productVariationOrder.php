<?php

namespace App\Models\productVariationOrder;

use Illuminate\Database\Eloquent\Model;

class productVariationOrder extends Model
{
    protected $fillable = [
        'order_id',
        'product_variation_id',
        'quantity'
    ];
}
