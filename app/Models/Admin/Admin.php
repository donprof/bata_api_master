<?php

namespace App\Models\Admin;

use App\Models\Traits\ImageUrlLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable, ImageUrlLink;

    protected $fillable = [
        'name',
        'email',
        'email',
        'avatar',
        'password',
        'accountstatus'
    ];

    protected $hidden = [
        'password','remember_token'
    ];


    public function getStateAttribute()
    {
        if ($this->accountstatus == 1) {
            return "Active";
        }else{
            return "Suspended";
        }
    }

    protected $appends = ['imagelink','state'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
