<?php

namespace App\Http\Requests\Member\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DesigneeRequest extends FormRequest
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
            'user_id'=>'',
            'hoa_member_designee_name'=>'required',
            'hoa_member_designee_relation'=>'required',
            'hoa_member_bday'=>'required',
            'hoa_member_designee_modifiedby'=>''
        ];
    }
}
