<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AnnouncementActionResource extends JsonResource
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
            'type'=>$this->hoa_event_notices_type,
            'title'=>$this->hoa_event_notices_title,
            'desc'=>$this->hoa_event_notices_desc,
            'photo'=>$this->hoa_event_notices_photo ? URL::to($this->hoa_event_notices_photo) : null,
            'story'=>$this->hoa_event_notices_fullstory
        ];
    }
}
