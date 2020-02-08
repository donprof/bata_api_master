<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'imagelink' => $this->imagelink,
            'gendarname' => $this->gendarname,
            'dateofbirth' => $this->dateofbirth,
            'addresses' => $this->addresses,
            'promocode' => $this->promocode,
            'paymentMethods' => $this->paymentMethods,
        ];
    }
}
