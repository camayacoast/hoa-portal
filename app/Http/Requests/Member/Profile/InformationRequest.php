<?php

namespace App\Http\Requests\Member\Profile;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
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
            'lotId'=>'required',
            'hoa_member_lname'=>'required',
            'hoa_member_fname'=>'required',
            'hoa_member_mname'=>'',
            'email'=>'required',
            'hoa_member_phone_num'=>'required',
            'hoa_subd_name'=>'required',
            'hoa_subd_lot_street_name'=>'required',
            'hoa_subd_lot_house_num'=>'required',
            'hoa_subd_lot_block'=>'required',
            'hoa_subd_lot_num'=>'required',
            'hoa_subd_lot_area'=>'required'
        ];
    }
}
