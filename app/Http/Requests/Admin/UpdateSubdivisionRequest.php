<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubdivisionRequest extends FormRequest
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
            'hoa_subd_name'=>'required|unique:subdivisions,hoa_subd_name,'.$this->id,
            'hoa_subd_area'=>'required',
            'image' => 'nullable|string',
            'hoa_subd_blocks'=>'required',
            'hoa_subd_lots'=>'required',
            'hoa_subd_contact_person'=>'required',
            'hoa_subd_contact_number'=>'required'
        ];
    }
}
