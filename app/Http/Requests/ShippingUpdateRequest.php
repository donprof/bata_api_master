<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingUpdateRequest extends FormRequest
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
            'country_id' => 'required|numeric|exists:countries,id',
            'shipping_method_id' => 'required|numeric|exists:shipping_methods,id',
            'id' => 'required|numeric|exists:country_shipping_method,id',
        ];
    }
}
