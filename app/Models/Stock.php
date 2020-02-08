<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'quantity',
        'product_variation_id'
    ];

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
