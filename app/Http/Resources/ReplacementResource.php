<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplacementResource extends JsonResource
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
            "uuid" => (string)$this->uuid,
            "inplayer" => PlayerResource::make($this->inPlayer),
            "outplayer" => PlayerResource::make($this->outPlayer),
        ];
    }
}
