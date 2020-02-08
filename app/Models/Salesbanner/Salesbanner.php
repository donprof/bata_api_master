<?php

namespace App\Models\Salesbanner;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Salesbanner extends Model
{
    protected $fillable = [
        'title','blinker','description','image','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSales($query)
    {
        return $query->get();
    }
}
