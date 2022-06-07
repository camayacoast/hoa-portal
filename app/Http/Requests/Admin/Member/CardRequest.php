<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
            'hoa_rfid_num'=>'required',
            'hoa_rfid_semnox_num'=>'required',
            'hoa_rfid_reg_privilege_load'=>'required',
            'hoa_rfid_reg_status'=>'required',
            'hoa_rfid_reg_modified'=>'',

        ];
    }
}
