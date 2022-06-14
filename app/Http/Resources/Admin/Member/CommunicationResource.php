<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
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
            'hoa_comm_template_name'=>$this->hoa_comm_template_name,
            'hoa_comm_template_title'=>$this->hoa_comm_template_title,
            'hoa_comm_template_subject'=>$this->hoa_comm_template_subject,
            'hoa_comm_template_message'=>$this->hoa_comm_template_message
        ];
    }
}
