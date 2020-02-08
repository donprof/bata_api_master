<?php

namespace App\Models;

use App\Models\Brands\Brands;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productimages\Productimages;
use App\Models\Comments\Comments;
use App\Models\Traits\ImageUrlLink;

class Product extends Model
{
    use CanBeScoped, HasPrice, ImageUrlLink;

    protected $fillable = [
        'name',
        'slug',
        'material',
        'code',
        'productcode',
        'brand_id',
        'price',
        'sizerange',
        'latest',
        'description',
        'icon',
        'icon2',
        'warehouse_id',
        'circular_no',
        'shoe_status',
        'source',
        'badgename',
        'latestcolor',
    ];

    protected $appends = ['latestname','imagelink'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getLatestnameAttribute()
    {
        $retVal = ($this->latest == 1) ? "Latest" : "Not";
        return $retVal;
        // if ($this->latest == 1) {
        //     return "Latest";
        // }elseif ($this->latest == '') {
        //     return "Not";
        // }else{}
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }
    
    public function stockCount()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function thumbs()
    {
        return $this->hasMany(Productimages::class)->where('status', 1)->orderBy('id','asc');
    }

    public function normal_size()
    {
        return $this->hasMany(Productimages::class)->where('status', 2)->orderBy('id','asc');
    }

    public function large_size()
    {
        return $this->hasMany(Productimages::class)->where('status', 3)->orderBy('id','asc');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->orderBy('id', 'asc');
    }

    public function drandname()
    {
        return $this->belongsTo(Brands::class, 'brand_id')->orderBy('id', 'asc');
    }
}
