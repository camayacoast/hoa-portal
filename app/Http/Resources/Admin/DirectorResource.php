<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class DirectorResource extends JsonResource
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
            'subdivision_id'=>$this->id,
            'fullName'=>$this->user->full_name,
//            'fullName'=>$this->user->hoa_member_lname.' '.$this->user->hoa_member_fname.' '.$this->user->hoa_member_mname,
            'hoa_bod_desc'=>$this->hoa_bod_desc,
            'hoa_bod_position'=>$this->hoa_bod_position,
            'image_url'=>$this->image ? URL::to($this->image) : null,
        ];
    }
}
