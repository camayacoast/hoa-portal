<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
           'hoa_sales_agent_email'=>'required|string|email|unique:agents,hoa_sales_agent_email',
            'hoa_sales_agent_fname'=>'required',
            'hoa_sales_agent_lname'=>'required',
            'hoa_sales_agent_mname'=>'',
            'hoa_sales_agent_suffix'=>'',
            'hoa_sales_agent_contact_number'=>'required',
            'hoa_sales_agent_supervisor'=>'required'

        ];
    }
}
