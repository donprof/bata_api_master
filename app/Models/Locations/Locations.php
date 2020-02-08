<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = [
        'name','description','gradient','image','link'
    ];

    public function scopeLocations($query)
    {
        return $query->get();
    }
}
