<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTransactionResource extends JsonResource
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
            'statement_number'=>$this->hoa_billing_statement_number,
            'total_cost'=>$this->hoa_billing_total_cost,
            'past_due'=>$this->hoa_billing_past_due,
            'amount_paid'=>$this->hoa_billing_amount_paid,
            'hoa_billing_status'=>$this->hoa_billing_status,
            'bill_month'=>$this->hoa_billing_generated_date,
            'hoa_billing_date_paid'=>$this->hoa_billing_date_paid
        ];
    }
}
