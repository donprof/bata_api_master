<?php

namespace App\Models\Slider;

use App\Models\Category;
use App\Models\Traits\ImageUrlLink;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Slider extends Model
{
    use ImageUrlLink;

    protected $fillable = [
        'title','categoriesid','description','image','gradient','user_id'
    ];

    public function getSlugAttribute()
    {
        return Category::where('id',$this->categoriesid)->pluck('slug')->first();
    }

    protected $appends = ['imagelink','slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSliders($query)
    {
        return $query->get();
    }

    public function scopeSliderslist($query)
    {
        return $query->with(["user"])->get();
    }
}
