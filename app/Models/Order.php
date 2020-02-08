<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Ordernumbers\Ordernumbers;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const PAYMENT_FAILED = 'payment_failed';
    const COMPLETED = 'completed';

    protected $fillable = [
        'order_number',
        'status',
        'points_status',
        'address_id',
        'shipping_method_id',
        'payment_method_id',
        'subtotal',
        'voucher',
        'merchantrequestid',
        'checkoutrequestid',
        'transaction_external_id'
    ];

    protected $appends = ['dayname', 'isCurrentWeek'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->status = self::PENDING;
        });
    }

    // public function getSubtotalAttribute($subtotal)
    // {
        // if ($this->voucher != null) {
        //     return new Money($subtotal - intval($this->voucher.'00'));
        // }else {
        //     return new Money($subtotal);
        // }
        // return $subtotal;
        // return new Money($subtotal);
    // }

    public function total()
    {
        // \Log::info($this->subtotal + $this->shippingMethod->price);
        // return $this->shippingMethod->price;
        return $this->subtotal + $this->shippingMethod->price;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getDaynameAttribute()
    {
        return Carbon::parse($this->created_at)->format('l');
    }

    public function getIsCurrentWeekAttribute()
    {
        return Carbon::parse($this->created_at)->format('W-YYYY') == Carbon::now()->format('W-YYYY');
    }

    private function dateRanges($date, $flag)
    {
        switch ($flag) {
            case 0: # week range
                $start = Carbon::parse($date)->startOfWeek()->toDateString();
                $end = Carbon::parse($start)->endOfWeek()->toDateString();
                return ["start" => $start, "end" => $end];
            case 1: # day range
                $start = Carbon::parse($date)->startOfDay()->toDateTimeString();
                $end = Carbon::parse($start)->endOfDay()->toDateTimeString();
                return ["start" => $start, "end" => $end];
            default:
                throw new \Exception("No date range calculated", 1);
                break;
        }
    }

    public function scopeWeek($query, $date)
    {
        $range = $this->dateRanges($date, 0);
        return $query->whereBetween('created_at', [$range['start'], $range['end']])->where('status', 'completed');
    }
}
