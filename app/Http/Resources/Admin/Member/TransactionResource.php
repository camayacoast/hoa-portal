<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'hoa_privilege_transaction_name'=>$this->hoa_privilege_transaction_name,
            'hoa_privilege_transaction_desc'=>$this->hoa_privilege_transaction_desc,
            'hoa_privilege_transaction_amount'=>$this->hoa_privilege_transaction_amount,
            'hoa_privilege_booking_num'=>$this->hoa_privilege_booking_num,
            'hoa_privilege_transaction_type'=>$this->hoa_privilege_transaction_type,
            'created_at'=>$this->created_at
        ];
    }
}
