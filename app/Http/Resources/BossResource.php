<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use Illuminate\Http\Resources\Json\JsonResource;

class BossResource extends JsonResource
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
            "name" =>(string)$this->name,
            "start_year" =>(string)$this->start_year,
            "image" =>(string)$this->getFullPath($this->image),
        ];
    }
}
