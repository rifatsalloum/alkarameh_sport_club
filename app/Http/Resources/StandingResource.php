<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
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
            "uuid"=>(string)$this->uuid,
            "name" =>(string)$this->club->name,
            "win"=>(string)$this->win,
            "lose"=>(string)$this->lose,
            "draw"=>(string)$this->draw,
            "diff"=>(string)$this->diff,
            "points"=>(string)$this->points,
            "play"=>(string)$this->play,
        ];
    }
}
