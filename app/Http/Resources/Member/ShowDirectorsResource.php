<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ShowDirectorsResource extends JsonResource
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
            'description'=>$this->hoa_bod_desc,
            'position'=>$this->hoa_bod_position,
            'fullName'=>$this->user->full_name,
            'image'=>$this->image ? URL::to($this->image) : null,
        ];
    }
}
