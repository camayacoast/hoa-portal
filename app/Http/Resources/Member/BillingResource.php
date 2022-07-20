<?php

namespace App\Http\Resources\Member;

use App\Http\Resources\Admin\Member\FeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            'billing'=>BillingStatementResource::collection($this->billing),
            'subdivision_name'=>$this->subdivision->hoa_subd_name,
            'block_number'=>$this->hoa_subd_lot_block,
            'lot_area'=>$this->hoa_subd_lot_area,
            'designee' => $this->user->designee()->count(),
            'lot_number'=>$this->hoa_subd_lot_num,
            'dues'=>DuesResource::collection($this->subdivision->due),
            'fees'=>FeesResource::collection($this->fee)
        ];
    }
}
