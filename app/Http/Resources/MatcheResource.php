<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use Illuminate\Http\Resources\Json\JsonResource;
use \Carbon\Carbon;
class MatcheResource extends JsonResource
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
        $result = ($this->type != "not_started")? $this->statistics->where("name","النتيجة")->first() : null;
        $result = ($result)? json_decode($result->value) : null;
        if($result){
            $result->team1 = (string) $result->team1;
            $result->team2 = (string) $result->team2;
        }
        return  [
            "uuid" => (string)$this->uuid,
            "date" => (string)Carbon::parse($this->when)->locale("ar")->translatedFormat("Y/n/d D"),
            "time" => (string)Carbon::parse($this->when)->locale("ar")->translatedFormat("a g:i"),
            "plan" => ($this->plan != "null")? (string)$this->getFullPath($this->plan) : null,
            "channel" => (string)$this->channel,
            "round" => (string)$this->round,
            "play_ground" => (string)$this->play_ground,
            "team1" => ClubResource::make($this->firstClub),
            "team2" => ClubResource::make($this->secondClub),
            "result" => $result,
            "player" => PlayerResource::make($request->im),
        ];
    }
}
