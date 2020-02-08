<?php

namespace App\Models\ShippingMethods;

use Illuminate\Database\Eloquent\Model;

class ShippingMethods extends Model
{
    protected $fillable = [
        'name','description','price'
    ];

    protected $appends = ['realprice'];

    public function getRealpriceAttribute()
    {
        if ($this->price == 0) {
            return 0;
        }else {
            return $this->price;
        }
    }

    public function scopeShippingmethods($query)
    {
        return $query->get();
    }
}
