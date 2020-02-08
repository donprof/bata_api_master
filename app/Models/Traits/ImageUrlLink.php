<?php

namespace App\Models\Traits;

trait ImageUrlLink
{
    public function getImagelinkAttribute()
    {
        return asset('storage').'/';
    }
}
