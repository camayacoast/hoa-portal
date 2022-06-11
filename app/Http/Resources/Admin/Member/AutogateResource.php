<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class AutogateResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'template_id'=>$this->template_id,
            'hoa_autogate_member_name'=>$this->hoa_autogate_member_name,
            'hoa_autogate_subdivision_name'=>$this->hoa_autogate_subdivision_name,
            'hoa_autogate_start'=>$this->hoa_autogate_start,
            'hoa_autogate_end'=>$this->hoa_autogate_end,
            'hoa_autogate_message'=>$this->template->hoa_autogate_template_name
        ];
    }
}
