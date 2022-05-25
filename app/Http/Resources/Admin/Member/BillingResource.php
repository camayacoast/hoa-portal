<?php

namespace App\Http\Resources\Admin\Member;

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
            'id'=>$this->id,
            'user_id'=>$this->user->id,
            'hoa_subd_lot'=>$this->hoa_subd_lot,
            'hoa_billing_total_cost'=>$this->hoa_billing_total_cost,
            'hoa_billing_due_date'=>$this->hoa_billing_due_date,
            'hoa_billing_status'=>$this->hoa_billing_status
        ];
    }
}
