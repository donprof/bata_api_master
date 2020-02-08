<?php

namespace App\Http\Requests\ProductVariationType;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationTypeRequest extends FormRequest
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
            'description'   => 'required|max:10|min:3|unique:product_variation_types,name',
            'colorcode'     => 'required|max:25|min:16|unique:product_variation_types,colorcode',
        ];
    }
}
