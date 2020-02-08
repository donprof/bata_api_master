<?php

namespace App\Http\Requests\Images;

use Illuminate\Foundation\Http\FormRequest;

class OfferimageRequest extends FormRequest
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
            'products' => 'required'
            // 'image' => 'required|image|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'products.products' => 'Hmmm.., Not a valid image.'
        ];
    }
}
