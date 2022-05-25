<?php

namespace App\Http\Resources\Admin\Member;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->user->full_name,
            'hoa_document_name' => $this->hoa_document_name,
            'files'=>FileResource::collection($this->file),
            'hoa_document_desc' => $this->hoa_document_desc,
            'created_at' => $this->created_at,
            'hoa_document_tag' => $this->hoa_document_tag
        ];
    }
}
