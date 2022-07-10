<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
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
            'subdivision_id'=>$this->subdivision_id,
            'agent_id'=>$this->agent_id,
            'hoa_subd_name'=>$this->subdivision->hoa_subd_name,
            'hoa_subd_lot_block'=>$this->hoa_subd_lot_block,
            'hoa_subd_lot_num'=>$this->hoa_subd_lot_num,
            'hoa_subd_lot_area'=>$this->hoa_subd_lot_area,
            'hoa_subd_lot_house_num'=>$this->hoa_subd_lot_house_num,
            'hoa_subd_lot_street_name'=>$this->hoa_subd_lot_street_name,
            'hoa_subd_lot_default'=>$this->hoa_subd_lot_default,
            'hoa_sales_agent_name'=>$this->agent->hoa_sales_agent_fname.' '.$this->agent->hoa_sales_agent_mname.' '.$this->agent->hoa_sales_agent_lname,
            'hoa_sales_agent_contact_number'=>$this->agent->hoa_sales_agent_contact_number
        ];
    }
}
