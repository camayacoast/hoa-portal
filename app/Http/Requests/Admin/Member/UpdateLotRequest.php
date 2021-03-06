<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLotRequest extends FormRequest
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
            'subdivision_id'=>'required',
            'user_id'=>'required',
            'agent_id'=>'required',
            'hoa_subd_lot_block'=>'required',
            'unique_lot'=>'required|unique:lots,unique_lot,'.$this->id,
            'hoa_subd_lot_area'=>'required',
            'hoa_subd_lot_num'=>'required',
            'hoa_subd_lot_house_num'=>'',
            'hoa_subd_lot_street_name'=>'',
            'hoa_subd_lot_default'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'agent_id.required'=>'The hoa subd lot sales agent name was required',
            'subdivision_id.required'=>'The hoa subd lot name was required',
            'unique_lot.unique'=>'this subdivision lot was totaly aquired',
        ];
    }
}
