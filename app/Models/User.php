<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Loyalty\Loyalty;
use App\Models\PaymentMethod;
use App\Models\Promocode\Promocode;
use App\Models\Traits\ImageUrlLink;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ImageUrlLink;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'newsletters', 'accountstatus', 'accounttype', 'created_at', 'gateway_customer_id','avatar','dateofbirth','gendar','phone','external_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['gendarname','loyaltypoint','earnedpoints','usedpoints', 'imagelink'];

    public function getGendarnameAttribute()
    {
        if ($this->gendar == 1) {
            return "Male";
        }elseif ($this->gendar == 2) {
            return "Female";
        }elseif ($this->gendar == 3){
            return "Rather not say";
        }else{}
    }

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

    public function cart()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getLoyaltypointAttribute()
    {
        return Loyalty::where('user_id',$this->id)->sum('earnedPoints') - Loyalty::where('user_id',$this->id)->sum('usedPoints');
    }

    public function getEarnedpointsAttribute()
    {
        return Loyalty::where('user_id',$this->id)->sum('earnedPoints');
    }

    public function getUsedpointsAttribute()
    {
        return Loyalty::where('user_id',$this->id)->sum('usedPoints');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function promocode()
    {
        return $this->hasMany(Promocode::class);
    }
}
