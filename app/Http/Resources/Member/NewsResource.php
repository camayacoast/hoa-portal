<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class NewsResource extends JsonResource
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
            'description'=>$this->hoa_event_notices_desc,
            'fulllStory'=>$this->hoa_event_notices_fullstory,
            'title'=>$this->hoa_event_notices_title,
            'type'=>$this->hoa_event_notices_type,
            'image'=>$this->hoa_event_notices_photo ? URL::to($this->hoa_event_notices_photo) : null,
        ];
    }
}
