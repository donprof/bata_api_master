<?php

namespace App\Models\Brands;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = [
        'name'
    ];

    public function scopeBrands($query)
    {
        return $query->whereIn('name', ['SAFARI','TOUGHEES', 'SANDAK', 'PATA PATA'])->get();
    }

    public static function getBrandId($name)
    {
        return static::where('name',$name)->first();
    }
}
