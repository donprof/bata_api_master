<?php

namespace App\Http\Requests\Mpesa;

use Illuminate\Foundation\Http\FormRequest;

class MpesaRequest extends FormRequest
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
            'Body.*.stkCallback' => 'required',
        ];
    }
}
