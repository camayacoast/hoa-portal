<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DueRequest extends FormRequest
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
            'subdivision_id' => 'required',
            'hoa_subd_dues_name' => 'required',
            'hoa_subd_dues_cost' => 'required',
            'hoa_subd_dues_unit' => 'required',
            'hoa_subd_dues_start_date' => 'required|date|after:yesterday',
            'hoa_subd_dues_end_date' => 'required|date|after_or_equal:hoa_subd_dues_start_date',
            'hoa_subd_dues_payment_target' => 'required|numeric|min:1|max:30',
            'hoa_subd_dues_cutoff_date' => 'required|numeric|min:1|max:30',
            'schedule_id' => 'required',
            'hoa_subd_dues_modifiedby'=>''
        ];

    }

    public function message()
    {
        return [
            'schedule_id.required'=>'the hoa subd dues_fees recurrent field was required'
        ];
    }
}
