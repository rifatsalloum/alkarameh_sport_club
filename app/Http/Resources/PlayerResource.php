<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use Illuminate\Http\Resources\Json\JsonResource;
use \Carbon\Carbon;
class PlayerResource extends JsonResource
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
        $born = Carbon::parse($this->born);
        return [
            "uuid"=>(string)$this->uuid,
            "name"=>(string)$this->name,
            "high"=>(string)($this->high . "cm"),
            "play"=>(string)$this->play,
            "number"=>(string)$this->number,
            "born"=>(string)$born->locale("ar")->translatedFormat("Y M j"),
            "age" =>(string)(Carbon::now()->year - $born->year),
            "from"=>(string)$this->from,
            "first_club"=>(string)$this->first_club,
            "career"=>(string)$this->career,
            "image"=>(string)$this->getFullPath($this->image),
        ];
    }
}
