<?php

namespace App\Http\Resources\Member\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class DesigneeResource extends JsonResource
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
            'hoa_member_designee_name'=>$this->hoa_member_designee_name,
            'hoa_member_designee_relation'=>$this->hoa_member_designee_relation,
            'hoa_member_bday'=>$this->hoa_member_bday,
        ];
    }
}
