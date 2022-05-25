<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'hoa_document_desc'=>'required',
            'filenames'=>'',
            'hoa_document_name'=>'required',
            'hoa_document_tag'=>'required',
            'hoa_document_modifiedby'=>''
        ];
    }
}
