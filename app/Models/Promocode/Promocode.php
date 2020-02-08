<?php

namespace App\Models\Promocode;

use App\Models\Voucherprice\Voucherprice;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'user_id','promocode','voucheprice_id','status'
    ];

    protected $appends = ['voucheprice'];

    public function getVouchepriceAttribute()
    {
        return Voucherprice::where('id',$this->voucheprice_id)->pluck('price')->first();
    }
}
