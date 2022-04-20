<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SubdivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'hoa_subd_name'=>$this->hoa_subd_name,
            'hoa_subd_area'=>$this->hoa_subd_area,
            'hoa_subd_blocks'=>$this->hoa_subd_blocks,
            'hoa_subd_lots'=>$this->hoa_subd_lots,
            'hoa_subd_contact_person'=>$this->hoa_subd_contact_person,
            'hoa_subd_contact_number'=>$this->hoa_subd_contact_number
        ];
    }
}
