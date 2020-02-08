<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationType extends Model
{
    protected $fillable = [
        'name',
        'colorcode',
        'code',
    ];

    public function scopeProductvariationtype($query)
    {
        return $query->orderBy("id", "DESC")->paginate(100);
    }

    public function scopeVariationlist($query)
    {
        return $query->get();
    }
}
