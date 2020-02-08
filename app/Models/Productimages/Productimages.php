<?php

namespace App\Models\Productimages;

use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Productimages extends Model
{
    protected $fillable = [
        'product_id','product_variation_type_id','status','image','user_id'
    ];
    
    protected $appends = ['url','colorname'];

    public function getColornameAttribute()
    {
        return ProductVariationType::where('id', $this->product_variation_type_id)->pluck('name')->first();
    }

    public function getUrlAttribute()
    {
        $returnpath = asset('storage').'/';
        if ($this->status == 1) {
            return $returnpath.'thumb/'.$this->image;
        }elseif ($this->status == 2) {
            return $returnpath.'normal/'.$this->image;
        }elseif ($this->status == 3) {
            return $returnpath.'large/'.$this->image;
        }else {}
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSales($query)
    {
        return $query->get();
    }
}
