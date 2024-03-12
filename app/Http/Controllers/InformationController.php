<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Information;
use App\Models\Club;
use App\Models\Matche;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Resources\InformationResource;
use App\Http\Traits\FileUploader;
use App\Models\Seasone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    use GeneralTrait;
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function aboutClub(Request $request){
        try{
        return InformationResource::collection($request->club->informations->where("type","regular"));
        }catch(\Exception $e)
        {
            throw new HttpResponseException($this->notFoundResponse(message()));
        }
    }
    public function clubStrategies(Request $request){
        try{
        return InformationResource::collection($request->club->informations->where("type","strategy"));
        }catch(\Exception $e){
            throw new HttpResponseException($this->notFoundResponse(message()));
        }
    }
    public function allNews(Request $request){
        try{
        return $this->apiResponse(InformationResource::collection(Information::where("type","news")->orderBy("created_at","desc")->get()));
        }catch(\Exception $e){
            return $this->notFoundResponse(message());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInformationRequest $request)
    {
        try{
        if($request->type == "news" && $request->matche_id){
            $obj = Matche::where("uuid",$request->matche_id)->firstOrFail();

            if($obj->status == "not_started")
             return $this->requiredField(message("لايمكن وجود أخبار لمباريات لاتملك احصائيات"));

            $data = $obj->news()->create([
                "uuid" => Str::uuid(),
                "title" => $request->title,
                "content" => $request->content,
                "image" => $this->uploadImagePublic($request,"news","news"),
                "type"=>$request->type
            ]);
           if($data)
            return $this->apiResponse(message(null,2));
           else
            return $this->requiredField(message(null,3));
        }
        else{
            $club = Club::where("name","الكرامة")->firstOrFail();
            $data = $club->informations()->create([
                "uuid" => Str::uuid(),
                "title" => $request->title,
                "content" => $request->content,
                "image" => $this->uploadImagePublic($request,(($request->type == "news")? "new" : $request->type),(($request->type == "news")? "news" : $request->type . "s")),
                "type"=>$request->type
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
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInformationRequest $request)
    {
        try{
        $information = Information::where("uuid",$request->information_id)->firstOrFail();

        $information->title = $request->title;
        $information->content = $request->content;
        $this->deleteImage($information->image);
        $information->image = $this->uploadImagePublic($request,(($information->type == "news")? "new" : $information->type),(($information->type == "news")? "news" : $information->type . "s"));

        $data = $information->save();

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
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        //
    }
}
