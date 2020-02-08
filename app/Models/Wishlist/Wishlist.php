<?php

namespace App\Models\Wishlist;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'product_id',
        'user_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeWishlist($query)
    {
        $user = request()->user()->id;
        return $query->where('user_id', $user)->count();
    }
    
    public function scopeAllwishlist($query)
    {
        $user = request()->user()->id;
        return $query->with(['products'])->where('user_id', $user)->get();
    }
}
