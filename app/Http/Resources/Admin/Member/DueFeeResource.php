<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class DueFeeResource extends JsonResource
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
            'fullName'=>$this->user->full_name,
            'subdivisionName'=>$this->subdivision->hoa_subd_name,
            'street'=>$this->hoa_subd_lot_street_name
        ];
    }
}
