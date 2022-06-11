<?php

namespace App\Http\Requests\Admin\Member;

use App\Rules\MaxWordsRule;
use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
            'hoa_autogate_template_name'=>'required',
            'hoa_autogate_template_title'=>'required',
            'hoa_autogate_template_message'=>['required',new MaxWordsRule()],
            'hoa_autogate_modifiedby'=>''
        ];
    }
}
