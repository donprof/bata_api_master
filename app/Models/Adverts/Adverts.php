<?php

namespace App\Models\Adverts;

use App\Models\Category;
use App\Models\Traits\ImageUrlLink;
use Illuminate\Database\Eloquent\Model;

class Adverts extends Model
{
    use ImageUrlLink;
    
    protected $fillable = [
        'title','slugid','blinker','description','image','gradient','user_id'
    ];
    protected $appends = ['imagelink','slug'];

    public function getSlugAttribute()
    {
        return Category::where('id',$this->slugid)->pluck('slug')->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAdverts($query)
    {
        return $query->get();
    }

    public function scopeAdvertslist($query)
    {
        return $query->with(["user"])->get();
    }
}
