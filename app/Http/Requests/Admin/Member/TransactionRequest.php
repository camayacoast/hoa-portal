<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'hoa_privilege_transaction_name'=>'required',
            'hoa_privilege_transaction_desc'=>'required',
            'hoa_privilege_transaction_amount'=>'required',
            'hoa_privilege_booking_num'=>'required',
            'hoa_privilege_transaction_type'=>'required',
            'card_id'=>'required',
            'hoa_transaction'=>''
        ];
    }
}
