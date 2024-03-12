<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $value = json_decode($this->value);
        $value->team1 = (string) $value->team1;
        $value->team2 = (string) $value->team2;
        return [
            "name" => $this->name,
            "value" => $value,
        ];
    }
}
