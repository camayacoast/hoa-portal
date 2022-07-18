<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingStatementResource extends JsonResource
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
            'bilingId'=>$this->id,
            'status'=>$this->hoa_billing_status,
            'statement_number'=>$this->hoa_billing_statement_number,
            'statement_date'=>$this->hoa_billing_due_dates,
            'current_due'=>number_format($this->hoa_billing_total_cost,2),
            'past_due'=>number_format($this->hoa_billing_past_due,2),
            'total_cost'=>number_format($this->hoa_billing_past_due + $this->hoa_billing_total_cost,2),
            'payment_due'=>$this->hoa_billing_generated_date,
        ];
    }
}
