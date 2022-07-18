<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DueResource extends JsonResource
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
            'hoa_subd_dues_name'=>$this->hoa_subd_dues_name,
            'hoa_subd_dues_cost'=>$this->hoa_subd_dues_cost,
            'hoa_subd_dues_unit'=>$this->hoa_subd_dues_unit,
            'hoa_subd_dues_start_date'=>$this->hoa_subd_dues_start_date,
            'hoa_subd_dues_end_date'=>$this->hoa_subd_dues_end_date,

            'schedule_id'=>$this->schedule_id,
            'hoa_schedule_name'=>$this->schedule->hoa_schedule_name,
            'hoa_subd_dues_status'=>$this->hoa_subd_dues_status,
            'unit_id'=>$this->unit_id,
            'unit'=>$this->unit->name
        ];
    }
}
