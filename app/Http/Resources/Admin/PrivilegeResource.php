<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivilegeResource extends JsonResource
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
            'hoa_privilege_package_name'=>$this->hoa_privilege_package_name,
            'hoa_privilege_package_desc'=>$this->hoa_privilege_package_desc,
            'hoa_privilege_package_category'=>$this->hoa_privilege_package_category,
            'hoa_privilege_package_cost'=>$this->hoa_privilege_package_cost,
        ];
    }
}
