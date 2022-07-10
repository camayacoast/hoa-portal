<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubdivisionRequest extends FormRequest
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
            'hoa_subd_name'=>'required|unique:subdivisions,hoa_subd_name',
            'hoa_subd_area'=>'',
            'image' => 'nullable|string',
            'hoa_subd_blocks'=>'required',
            'hoa_subd_lots'=>'required',
            'hoa_subd_contact_person'=>'required',
            'hoa_subd_contact_number'=>'required'
        ];
    }
}
