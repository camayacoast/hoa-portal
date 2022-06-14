<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'schedule_id'=>$this->schedule_id,
            'communication_id'=>$this->communication_id,
            'hoa_email_sched'=>$this->hoa_email_sched,
            'fullName'=>$this->user->full_name,
            'email'=>$this->user->email,
            'schedule'=>$this->schedule->hoa_schedule_name,
            'templateName'=>$this->communication->hoa_comm_template_name

        ];
    }
}
