<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociationResource extends JsonResource
{
    use GeneralTrait;
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
            "uuid" =>(string)$this->uuid,
            "boss" =>(string)$this->boss,
            "image" =>(string)$this->getFullPath($this->image),
            "description"=>(string)$this->description,
            "country"=>(string)$this->country,
            "members" => TopFanResource::collection($this->topFans),
            "videos" => VideoResource::collection($this->videos),
        ];
    }
}
