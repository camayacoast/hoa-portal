<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class AutogateRequest extends FormRequest
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
            'user_id'=>'required',
            'template_id'=>'required',
            'hoa_autogate_member_name'=>'required',
            'hoa_autogate_subdivision_name'=>'required',
            'hoa_autogate_start'=>'required|date|after:yesterday',
            'hoa_autogate_end'=>'required|date|after_or_equal:hoa_autogate_start',
            'hoa_autogate_modifiedby'=>''
        ];
    }
}
