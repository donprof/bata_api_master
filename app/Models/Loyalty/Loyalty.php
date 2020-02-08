<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    protected $fillable = [
        'user_id','usedPoints','earnedPoints','order_id','state'
    ];
}
