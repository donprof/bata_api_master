<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:20|min:3|unique:products,name',
            'price' => 'required | numeric',
            'description' => 'required|max:50|min:3',
            // 'icon1' => 'required',
            // 'icon2' => 'required',
        ];
    }
}
