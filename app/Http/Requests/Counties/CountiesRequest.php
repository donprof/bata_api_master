<?php

namespace App\Http\Requests\Counties;

use Illuminate\Foundation\Http\FormRequest;

class CountiesRequest extends FormRequest
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
            'name' => 'required|max:20|unique:countries,name',
            'code' => 'required|max:2|unique:countries,code'
        ];
    }
}
