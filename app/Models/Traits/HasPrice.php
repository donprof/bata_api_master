<?php

namespace App\Models\Traits;

use App\Cart\Money;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Nexmo\Account\Price;
use NumberFormatter;

trait HasPrice
{
    // public function getPriceAttribute($value)
    // {
    //     return new Money($value);
    // }

    // public function getFormattedPriceAttribute()
    // {
    //     return $this->price->formatted();
    // }

    public function getPriceAttribute($value)
    {
        return $value;
        // return (int) ($value - ($value * 0.1));
    }

    // public function getFormattedPriceAttribute()
    // {
    //     return $this->price - ($this->price * 0.1);
    // }

    public function getOfferpriceAttribute()
    {
        return $this->price;
        // return round(($this->price * 100) / 90);
    }

    public function getActualpriceAttribute()
    {
        return $this->price;
    }
}
