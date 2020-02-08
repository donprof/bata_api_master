<?php

namespace App\Models\category_product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class category_product extends Model
{
    protected $table = 'category_product';
    protected $fillable = [
        'category_id', 'product_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function scopeCategory_product($query)
    {
        return $query->with(['product','category'])->orderBy('category_id','asc')->paginate(60);
    }
}
