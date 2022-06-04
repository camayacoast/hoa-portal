<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'full_name'=>$this->user->full_name,
            'hoa_rfid_num'=>$this->hoa_rfid_num,
            'hoa_rfid_semnox_num'=>$this->hoa_rfid_semnox_num,
            'created_at'=>$this->created_at,
            'hoa_rfid_reg_status'=>$this->hoa_rfid_reg_status,
            'hoa_rfid_reg_privilege_load'=>$this->hoa_rfid_reg_privilege_load
        ];
    }
}
