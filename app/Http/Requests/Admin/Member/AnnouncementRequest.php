<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
            'hoa_event_notices_title'=>'required',
            'hoa_event_notices_desc'=>'required',
            'hoa_event_notices_type'=>'required',
            'hoa_event_notices_photo'=>'required',
            'hoa_event_notices_modifiedby'=>'',
            'subdivision_id'=>''
        ];
    }
}
