<?php

namespace App\Http\Resources;

use App\Http\Traits\FileUploader;
use Carbon\CarbonInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StatisticResource;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\VideoResource;
use App\Models\Matche;

class InformationResource extends JsonResource
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
        $b = false;
        $matche = null;
        if($this->information_able_type == "App\Models\Matche"){
            $b = true;
            $matche = $this->information_able;
            $videos = $this->getVideos();
        }
        
        return [
            "uuid" => (string)$this->uuid,
            "title" => (string)$this->title,
            "content" => (string)$this->content,
            "image" => (string)$this->getFullPath($this->image),
            "type" => (string)$this->type,
            "date" => (string)$this->created_at->locale("ar")->diffForHumans(),
            "statistics" => ($b)? StatisticResource::collection($matche->statistics) : [],
            "club1" => ($b)? ClubResource::make($matche->firstClub) : null,
            "club2" => ($b)? ClubResource::make($matche->secondClub) : null,
            "videos" => ($b)? VideoResource::collection($videos) : [],
        ];
    }
    private function getVideos(){
        return Matche::where("id",$this->information_able_id)->firstOrFail()->videos;
    }
}
