<?php

namespace App\Models\Ordernumbers;

use Illuminate\Database\Eloquent\Model;

class Ordernumbers extends Model
{
    protected $fillable = [
        'number'
    ];

    public function scopeOrdernumber($query)
    {
        $order = $query->latest()->first();
        $orderNumber = $order->number;
        $increase = substr($orderNumber, 6);
        $newvalue = intval($increase) + 1;
        $final = '51600-'.$newvalue;
        return $final;
    }
}
