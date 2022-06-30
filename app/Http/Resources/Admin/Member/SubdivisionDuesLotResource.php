<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class SubdivisionDuesLotResource extends JsonResource
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
            'lot_area'=>$this->hoa_subd_lot_area,
            'dues'=>SubdivisionDuesResource::collection($this->subdivision->due)
        ];
    }
}
