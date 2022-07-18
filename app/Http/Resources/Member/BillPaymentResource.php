<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class BillPaymentResource extends JsonResource
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
            'total_cost'=>number_format($this->hoa_billing_past_due + $this->hoa_billing_total_cost,2),
            'payment_due'=>$this->hoa_billing_generated_date,
        ];
    }
}
