<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowScheduleResource extends JsonResource
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
            'schedule_id'=>$this->id,
            'hoa_schedule_name'=>$this->schedule->hoa_schedule_name,
            'hoa_schedule_desc'=>$this->schedule->hoa_schedule_desc
        ];;
    }
}
