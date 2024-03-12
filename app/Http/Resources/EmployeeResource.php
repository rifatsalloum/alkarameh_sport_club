<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    use FileUploader;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "uuid"=>(string)$this->uuid,
            "name"=>(string)$this->name,
            "work"=>(string)$this->work,
            "image"=>(string)$this->getFullPath($this->image),
        ];
    }
}
