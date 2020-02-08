<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductHomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'latestname' => $this->latestname,
            'icon' => $this->icon,
            'icon2' => $this->icon2,
            'productcode' => $this->productcode,
            'imagelink' => $this->imagelink,
            'latestcolor' => $this->latestcolor,
            'badgename' => $this->badgename,
            'shoe_status' => $this->shoe_status,
            'latest' => $this->latest,
            'description' => $this->description,
            'price' => $this->price,
            'offerprice' => $this->offerprice,
        ];
    }
}
