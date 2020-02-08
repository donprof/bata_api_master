<?php

namespace App\Models\Logs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = [
        'user_id','mpesalog','cardlog'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLogs($query)
    {
        return $query->with(['user'])->latest()->paginate(30);
    }
}
