<?php

namespace App\Http\Resources\Member\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'hoa_member_ebill'=>$this->hoa_member_ebill,
            'hoa_member_sms'=>$this->hoa_member_sms
        ];
    }
}
