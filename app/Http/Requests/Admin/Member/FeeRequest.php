<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
            'lot_id'=>'required',
            'schedule_id'=>'required',
            'hoa_fees_item'=>'required',
            'hoa_fees_desc'=>'',
            'hoa_fees_cost'=>'required',
            'hoa_fees_modifiedby'=>''
        ];
    }
}
