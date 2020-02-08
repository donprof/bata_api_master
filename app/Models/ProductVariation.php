<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Collections\ProductVariationCollection;
use App\Models\Product;
use App\Models\ProductVariationType;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasPrice;

    protected $fillable = [
        'product_id',
        'product_variation_type_id',
        'name',
        'price',
        'description',
        'order',
    ];

    protected $appends = ['variationtypename'];

    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }
        return $value;
        // return $value - ($value * 0.1);

        // return new Money($value);
    }

    public function minStock($count)
    {
        return min($this->stockCount(), $count);
    }

    public function priceVaries()
    {
        // return $this->price !== $this->product->price;
        return $this->price;
        // if ($this->price != null) {
        //     return $this->price !== $this->product->price;
        // }else{
        //     return $this->product->price;
        // }
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function getVariationtypenameAttribute()
    {
        return ProductVariationType::where('id',$this->product_variation_type_id)->pluck('name')->first();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class, 'product_variation_stock_view'
        )
            ->withPivot([
                'stock',
                'in_stock'
            ]);
    }

    public function newCollection(array $models = [])
    {
        return new ProductVariationCollection($models);
    }
}
