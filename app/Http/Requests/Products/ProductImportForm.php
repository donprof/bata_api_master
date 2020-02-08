<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportForm extends FormRequest
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
            'products' => 'required|mimes:csv,txt|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'products.products' => 'Hmmm.., Not a valid csv file.'
        ];
    }
}
