<?php

namespace App\Http\Requests\Images;

use Illuminate\Foundation\Http\FormRequest;

class IconImageRequest extends FormRequest
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
            'images' => 'required|array'
            // 'image' => 'required|image|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'image.image' => 'Hmmm.., Not a valid image.'
        ];
    }
}
