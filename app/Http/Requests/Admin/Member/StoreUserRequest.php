<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'hoa_member_lname'=>'required',
            'hoa_member_fname'=>'required',
            'hoa_member_mname'=>'required',
            'hoa_admin'=>'required',
            'hoa_member'=>'required',
            'email'=>'required|email|unique:users,email',
            'hoa_member_suffix'=>'',
            'hoa_member_ebill'=>'required',
            'hoa_member_sms'=>'required',
            'hoa_member_status'=>'',
        ];
    }
}
