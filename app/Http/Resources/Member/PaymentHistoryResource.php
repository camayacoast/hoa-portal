<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
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
            'bill_month'=>$this->hoa_billing_generated_date,
            'date_paid'=>$this->hoa_billing_date_paid,
            'balance'=>number_format($this->hoa_billing_past_due + $this->hoa_billing_total_cost,2),
            'status'=>$this->hoa_billing_status
        ];
    }
}
