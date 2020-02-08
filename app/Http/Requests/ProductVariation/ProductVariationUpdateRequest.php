<?php

namespace App\Http\Requests\ProductVariation;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationUpdateRequest extends FormRequest
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
            'id'    => 'required | numeric | exists:product_variations,id',
            'color' => 'required|numeric|exists:product_variation_types,id',
            'size'  => 'required|numeric|min:1',
        ];
    }
}
