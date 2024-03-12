<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Http\Resources\VideoResource;
use App\Models\Association;
use App\Models\Matche;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class VideoController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function bestGoals(Request $request){
        try{
        return VideoResource::collection($request->club->videos);
        }catch(\Exception $e){
            throw new HttpResponseException($this->notFoundResponse(message()));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        try{
        if($request->matche_id){
            $matche = Matche::where("uuid",$request->matche_id)->firstOrFail();

            if($matche->status == "not_started")
             return $this->requiredField(message("لايمكن أن يكون هناك ملخصات لمباريات لم تبدأ بعد"));

            $data = $matche->videos()->create([
            "uuid" => Str::uuid(),
            "url" => $request->url,
            "description" => $request->description,
        ]);
        if($data)
           return $this->apiResponse(message(null,2));
        else
           return $this->requiredField(message(null,3));
        }
        else if($request->association_id){
            $association = Association::where("uuid",$request->association_id)->firstOrFail();
            $data = $association->videos()->create([
            "uuid" => Str::uuid(),
            "url" => $request->url,
            "description" => $request->description,
        ]);
        if($data)
           return $this->apiResponse(message(null,2));
        else
           return $this->requiredField(message(null,3));
        }
        else
        {
            $club = Club::where("name","الكرامة")->firstOrFail();
            $data = $club->videos()->create([
            "uuid" => Str::uuid(),
            "url" => $request->url,
            "description" => $request->description,
        ]);
        if($data)
           return $this->apiResponse(message(null,2));
        else
           return $this->requiredField(message(null,3));
        }
    }catch(\Exception $e){
        return $this->requiredField(message(null,3));
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVideoRequest $request)
    {
        try{
        $video = Video::where("uuid",$request->video_id)->firstOrFail();
        $video->url = $request->url;
        $video->description = $request->description;

        $data = $video->save();

        if($data)
         return $this->apiResponse(message(null,0));
        else 
         return $this->requiredField(message(null,1));
        }catch(\Exception $e){
            return $this->requiredField(message(null,1));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }
}
