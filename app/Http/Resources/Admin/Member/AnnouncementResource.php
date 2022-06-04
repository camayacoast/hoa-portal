<?php

namespace App\Http\Resources\Admin\Member;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AnnouncementResource extends JsonResource
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
            'hoa_event_notices_title'=>$this->hoa_event_notices_title,
            'hoa_event_notices_desc'=>$this->hoa_event_notices_desc,
            'hoa_event_notices_type'=>$this->hoa_event_notices_type,
            'hoa_event_notices_fullstory'=>$this->hoa_event_notices_fullstory,
            'hoa_event_notices_photo'=>$this->hoa_event_notices_photo ? URL::to($this->hoa_event_notices_photo) : null,
            'created_at'=>$this->created_at,
            'subdivision'=>ShowSubdivisionResource::collection($this->subdivisions)
        ];
    }
}
