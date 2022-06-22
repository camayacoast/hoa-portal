<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLotSubdivisionResource extends JsonResource
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
            'name'=>$this->subdivision->hoa_subd_name
        ];
    }
}
