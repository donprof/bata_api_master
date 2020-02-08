<?php

namespace App\Models\Ordersreports;

use Illuminate\Database\Eloquent\Model;

class Ordersreports extends Model
{
    public $fillable = [
        'title','number','apislug','desc'
    ];
    public function scopeOrdersreports($query)
    {
        return $query->get();
    }
}
