<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'hoa_member'=>'required',
            'hoa_admin'=>'required',
            'hoa_access_type'=>'required',
            'id'=>'required',
            'subdivision_id'=>'required',
        ];
    }
}
