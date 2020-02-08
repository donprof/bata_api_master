<?php

namespace App\Models\Wavesection;

use App\Models\Category;
use App\Models\Traits\ImageUrlLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wavesection extends Model
{
    protected $fillable = [
        'title','categoryid','offer','description','image','user_id'
    ];

    use ImageUrlLink;

    public function getSlugAttribute()
    {
        return Category::where('id',$this->categoryid)->pluck('slug')->first();
    }

    protected $appends = ['imagelink','slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWave($query)
    {
        return $query->get();
    }
}
