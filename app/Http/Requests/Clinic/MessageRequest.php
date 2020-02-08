<?php

namespace App\Http\Requests\Clinic;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'name' => 'required|max:50|min:2',
            'email' => 'required|email|max:100|min:5',
            'phone' => 'required|numeric',
            'message' => 'required',
        ];
    }
}
