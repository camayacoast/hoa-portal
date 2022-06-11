<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'hoa_autogate_template_name'=>$this->hoa_autogate_template_name,
            'hoa_autogate_template_title'=>$this->hoa_autogate_template_title,
            'message'=>MessageResource::collection($this->message)
        ];
    }
}
