<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'schedule_id'=>'required',
            'user_id'=>'required',
            'communication_id'=>'required',
            'hoa_email_sched'=>'required|date|after:yesterday',
            'hoa_email_modifiedby'=>''
        ];
    }

    public function messages()
    {
        return[
          'schedule_id.required'=>'the schedule field is required',
            'user_id.required'=>'the email field is required',
            'communication_id.required'=>'the template field is required'
        ];
    }
}
