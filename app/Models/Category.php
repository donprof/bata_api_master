<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Traits\HasChildren;
use App\Models\Traits\ImageUrlLink;
use App\Models\Traits\IsOrderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasChildren, IsOrderable, ImageUrlLink;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'banner',
        'subcategory_id',
        'order'
    ];

    protected $appends = ['imagelink'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->slug = Str::slug(request()->name, '-');
        });

        static::updating(function ($category) {
            $category->slug = Str::slug(request()->name, '-');
        });
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('subchildren');
    }

    public function subchildren()
    {
        return $this->hasMany(Category::class, 'subcategory_id', 'id');
    }

    public function grouping()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'subcategory_id', 'id')->with('grouping');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
