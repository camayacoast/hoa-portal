<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'hoa_member_lname' => 'required|string',
            'hoa_member_fname' => 'required|string',
            'hoa_member_mname' => '',
            'hoa_member_suffix' => '',
            'email' => 'required|string|email|unique:users,email,' . $this->id,
            'hoa_member_sms' => '',
            'hoa_member_ebill' => '',
        ];
    }
    public function messages()
    {
        return [
            'hoa_member_lname.required' => 'The hoa member lastname field is required.',
            'hoa_member_fname.required' => 'The hoa member firstname field is required.',
        ];
    }
}
