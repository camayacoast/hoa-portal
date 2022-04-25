<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'hoa_sales_agent_email'=>$this->hoa_sales_agent_email,
            'hoa_sales_agent_fname'=>$this->hoa_sales_agent_fname,
            'hoa_sales_agent_lname'=>$this->hoa_sales_agent_lname,
            'hoa_sales_agent_mname'=>$this->hoa_sales_agent_mname,
            'hoa_sales_agent_suffix'=>$this->hoa_sales_agent_suffix,
            'hoa_sales_agent_contact_number'=>$this->hoa_sales_agent_contact_number,
            'hoa_sales_agent_supervisor'=>$this->hoa_sales_agent_supervisor,
            'hoa_sales_agent_status'=>$this->hoa_sales_agent_status
        ];
    }
}
