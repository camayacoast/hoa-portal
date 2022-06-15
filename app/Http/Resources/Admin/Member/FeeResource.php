<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends JsonResource
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
            'lot_id'=>$this->lot_id,
            'schedule_id'=>$this->schedule_id,
            'schedule'=>$this->schedule->hoa_schedule_name,
            'hoa_fees_item'=>$this->hoa_fees_item,
            'hoa_fees_desc'=>$this->hoa_fees_desc,
            'hoa_fees_cost'=>$this->hoa_fees_cost
        ];
    }
}
