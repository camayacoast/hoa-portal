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
//        $cost = $t;
////        $cost = $this->hoa_subd_dues_cost * $this->subdivision->lot->hoa_subd_lot_area;
        return[
            'item'=>$this->hoa_subd_dues_name,
            'cost'=> $this->hoa_subd_dues_cost,
//            'lot'=>$this->subdivision->lot[0]->hoa_subd_lot_area,
            'scheudle'=>$this->schedule->hoa_schedule_name
        ];
    }
}
