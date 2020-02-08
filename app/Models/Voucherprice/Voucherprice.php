<?php

namespace App\Models\Voucherprice;

use Illuminate\Database\Eloquent\Model;

class Voucherprice extends Model
{
    protected $fillable = [
        'price','status'
    ];

    public function scopeVoucherprice($query)
    {
        return $query->get();
    }
}
