<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'hoa_member_lname'=>$this->hoa_member_lname,
            'hoa_member_fname'=>$this->hoa_member_fname,
            'hoa_member_mname'=>$this->hoa_member_mname,
            'hoa_admin'=>$this->hoa_admin,
            'hoa_member'=>$this->hoa_member,
            'email'=>$this->email,
            'hoa_member_suffix'=>$this->hoa_member_suffix,
            'hoa_member_ebill'=>$this->hoa_member_ebill,
            'hoa_member_sms'=>$this->hoa_member_sms,
            'hoa_member_status'=>$this->hoa_member_status,
        ];
    }
}
