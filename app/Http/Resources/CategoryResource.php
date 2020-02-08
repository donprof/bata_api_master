<?php

namespace App\Http\Resources;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,
            'slug' => $this->slug,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'subchildren' => CategoryResource::collection($this->whenLoaded('subchildren'))
        ];
    }
}
