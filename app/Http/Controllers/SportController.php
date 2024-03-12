<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use App\Http\Resources\SportResource;
use Illuminate\Support\Str;


class SportController extends Controller
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
        try{
        return $this->apiResponse(SportResource::collection(Sport::all()));
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
    public function store(StoreSportRequest $request)
    {
        try{
        $data = Sport::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "image" => $this->uploadImagePublic($request,"sport","sports"),
        ]);

        if($data)
         return $this->apiResponse(message(null,2));
        else 
         return $this->requiredField(message(null,3));
    }catch(\Exception $e){
        return $this->requiredField(message(null,3));
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function show(Sport $sport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSportRequest $request)
    {
        try{
        $sport = Sport::where("uuid",$request->sport_id)->firstOrFail();
        
        $this->deleteImage($sport->image);
        $sport->image = $this->uploadImagePublic($request,"sport","sports");

        $data = $sport->save();
        
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
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sport $sport)
    {
        //
    }
}
