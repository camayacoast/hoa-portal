<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubdivisionResource extends JsonResource
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
            'fullName'=>$this->full_name,
            'email'=>$this->email,
            'subdivision'=>UserLotSubdivisionResource::collection($this->lot)
        ];
    }
}
