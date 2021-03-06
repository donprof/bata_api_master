<?php

namespace App\Http\Requests\Wavesection;

use Illuminate\Foundation\Http\FormRequest;

class WaveUpdateRequest extends FormRequest
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
            'id'      => 'required|numeric|exists:sliders,id',
            'title'   => 'required|max:25|min:3',
            'category'=> 'required|integer|exists:categories,id',
            'image'   => 'required',
            'gradient'=> 'required',
        ];
    }
}
