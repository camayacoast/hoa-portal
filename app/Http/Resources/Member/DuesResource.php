<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class DuesResource extends JsonResource
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
            'due_name'=>$this->hoa_subd_dues_name,
            'due_cost'=>$this->hoa_subd_dues_cost,
            'unit_id'=>$this->unit_id,
        ];
    }
}
