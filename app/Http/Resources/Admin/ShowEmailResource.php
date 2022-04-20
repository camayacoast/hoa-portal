<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowEmailResource extends JsonResource
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
            'hoa_member_mname'=>$this->hoa_member_fname
        ];
    }
}
