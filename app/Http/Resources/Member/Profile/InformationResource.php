<?php

namespace App\Http\Resources\Member\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
            'id'=>$this->user->id,
            'lotId'=>$this->id,
            'hoa_member_lname'=>$this->user->hoa_member_lname,
            'hoa_member_fname'=>$this->user->hoa_member_fname,
            'hoa_member_mname'=>$this->user->hoa_member_mname,
            'email'=>$this->user->email,
            'hoa_member_phone_num'=>$this->user->hoa_member_phone_num,
            'hoa_subd_name'=>$this->subdivision->hoa_subd_name,
            'hoa_subd_lot_street_name'=>$this->hoa_subd_lot_street_name,
            'hoa_subd_lot_house_num'=>$this->hoa_subd_lot_house_num,
            'hoa_subd_lot_block'=>$this->hoa_subd_lot_block,
            'hoa_subd_lot_num'=>$this->hoa_subd_lot_num,
            'hoa_subd_lot_area'=>$this->hoa_subd_lot_area
        ];
    }
}
