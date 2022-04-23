<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PrivilegeRequest extends FormRequest
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
            'hoa_privilege_package_name'=>'required',
            'hoa_privilege_package_desc'=>'required',
            'hoa_privilege_package_category'=>'required',
            'hoa_privilege_package_cost'=>'required|numeric|max:1',
            'hoa_privilege_package_createdby'=>''
        ];
    }
}
