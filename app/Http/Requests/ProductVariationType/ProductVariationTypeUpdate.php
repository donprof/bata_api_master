<?php

namespace App\Http\Requests\ProductVariationType;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariationTypeUpdate extends FormRequest
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
            'id'            => 'required | numeric | exists:product_variation_types,id',
            'description'   => 'required|max:20|min:3',
            'colorcode'     => 'required|max:25|min:16',
        ];
    }
}
