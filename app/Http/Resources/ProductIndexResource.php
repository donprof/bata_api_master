<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
            'brand_id' => $this->brand_id,
            'icon2' => $this->icon2,
            'thumbs' => $this->thumbs,
            'material' => $this->material,
            'productcode' => $this->productcode,
            'comments' => $this->comments,
            'normal_size' => $this->normal_size,
            'large_size' => $this->large_size,
            'imagelink' => $this->imagelink,
            'variations' => $this->variations,
            'latestcolor' => $this->latestcolor,
            'badgename' => $this->badgename,
            'shoe_status' => $this->shoe_status,
            'latest' => $this->latest,
            'description' => $this->description,
            'price' => $this->price,
            'offerprice' => $this->offerprice,
            'stock_count' => $this->stockCount(),
            'in_stock' => $this->inStock(),
        ];
    }
}
