<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RealEmailAddress;

class RegisterRequest extends FormRequest
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
            'email' => [
                'required', 'email', 'unique:users,email'
            ],
            'name' => 'required',
            'phone' => 'required|phone_number|numeric|unique:users,phone',
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'phone.phone_number' => 'Must be 12-digit phone number (e.g 254711111111) and must not include spaces or special characters',
        ];
    }
}
