<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DirectorRequest extends FormRequest
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
           'user_id'=>'required',
            'subdivision_id'=>'required',
            'hoa_bod_desc'=>'',
            'hoa_bod_position'=>'required',
            'hoa_bod_modifiedby'=>'',
            "image"=>'',
            'hoa_access_type'=>''
        ];
    }

    public function messages()
    {
        return[
            'user_id.required'=>'the hoa board of directors full name field was required',
            'subdivision_id.required'=>'the hoa board of directors subdivision field was required',
            'hoa_bod_desc'=>'the hoa board of directors description field was required',
            'hoa_bod_position'=>'the hoa board of directors position field was required'
        ];
    }
}
