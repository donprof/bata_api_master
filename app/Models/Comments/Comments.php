<?php

namespace App\Models\Comments;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comments extends Model
{
    protected $fillable = [
        'product_id','comment','user_id','status',
    ];

    protected $appends = ['statename','username','userphoto'];

    public function getStatenameAttribute()
    {
        if ($this->status == 1) {
            return 'Approved';
        }elseif ($this->status == 2) {
            return 'Rejected';
        }else {}
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUsernameAttribute()
    {
        return User::where('id',$this->user_id)->pluck('name')->first();
    }

    public function getUserphotoAttribute()
    {
        return User::where('id',$this->user_id)->pluck('name')->first();
    }

    public function scopeComments($query)
    {
        return $query->get();
    }
}
