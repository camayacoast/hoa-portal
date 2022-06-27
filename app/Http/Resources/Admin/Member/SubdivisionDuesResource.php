<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class SubdivisionDuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cost = $this->hoa_subd_dues_cost * $this->subdivision->hoa_subd_area;
        return[
            'item'=>$this->hoa_subd_dues_name,
            'cost'=>$cost,
            'scheudle'=>$this->schedule->hoa_schedule_name
        ];
    }
}
