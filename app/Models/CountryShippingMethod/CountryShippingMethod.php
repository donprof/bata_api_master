<?php

namespace App\Models\CountryShippingMethod;

use App\Models\Country;
use App\Models\ShippingMethods\ShippingMethods;
use Illuminate\Database\Eloquent\Model;

class CountryShippingMethod extends Model
{
    protected $table = 'country_shipping_method';
    protected $fillable = [
        'country_id','shipping_method_id'
    ];

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function shippingmethods()
    {
        return $this->belongsTo(ShippingMethods::class, 'shipping_method_id');
    }

    public function scopeShippingmethod($query)
    {
        return $query->with(['countries','shippingmethods'])->get();
    }
}
