<?php

namespace App\Http\Requests\ShippingMethods;

use Illuminate\Foundation\Http\FormRequest;

class ShippingMethodsUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20',
            'price' => 'required|numeric',
            'description' => 'required|max:100|min:3',
            'id' => 'required|numeric|exists:shipping_methods,id',
        ];
    }
}
