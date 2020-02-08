<?php

namespace App\Http\Requests\ProductVariation;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationRequest extends FormRequest
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
            'size'  => 'required|numeric',
            // 'price' => 'required|numeric',
            'color' => 'required|integer|exists:product_variation_types,id',
            'product' => 'required|integer|exists:products,id',
        ];
    }
}
