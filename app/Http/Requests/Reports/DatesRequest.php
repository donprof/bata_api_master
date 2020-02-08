<?php

namespace App\Http\Requests\Reports;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DatesRequest extends FormRequest
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
            'datefrom' => 'required|date',
            'dateto'   => 'required | date | after_or_equal:'.Carbon::parse(request()->datefrom)->format('jS M Y'),
            'reporttype' => 'required',
            'apislug' => 'required',
        ];
    }
}
