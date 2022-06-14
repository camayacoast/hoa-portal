<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class CommunicationRequest extends FormRequest
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
            'hoa_comm_template_name'=>'required',
            'hoa_comm_template_title'=>'required',
            'hoa_comm_template_subject'=>'required',
            'hoa_comm_template_message'=>'required',
            'ho_comm_template_modifiedby'=>''
        ];
    }
}
