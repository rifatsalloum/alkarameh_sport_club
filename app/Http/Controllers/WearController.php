<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWearRequest;
use App\Http\Resources\WearResource;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Seasone;
use App\Models\Sport;
use App\Models\Wear;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class WearController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWearRequest $request)
    {
        try{
        $sport_id = Sport::where("uuid",$request->sport_id)->firstOrFail()->id;
        $seasone_id = Seasone::where("uuid",$request->seasone_id)->firstOrFail()->id;
        $data = Wear::create([
            "uuid" => Str::uuid(),
            "image" => $this->uploadImagePublic($request,"wear","wears"),
            "seasone_id" => $seasone_id,
            "sport_id" => $sport_id
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
     * @param  \App\Models\Wear  $wear
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try{
        return WearResource::make(Wear::where("seasone_id",Seasone::orderBy("start_date","desc")->firstOrFail()->id)->firstOrFail());
        }catch(\Exception $e){
            throw new HttpResponseException($this->notFoundResponse(message()));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wear  $wear
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWearRequest $request)
    {
        try{
        $wear = Wear::where("uuid",$request->wear_id)->firstOrFail();
        $this->deleteImage($wear->image);
        $wear->image = $this->uploadImagePublic($request,"wear","wears");

        $data = $wear->save();

        if($data)
         return $this->apiResponse(message(null,0));
        else 
         return $this->requiredField(message(null,3));
        }catch(\Exception $e){
            return $this->requiredField(message(null,3));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wear  $wear
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wear $wear)
    {
        //
    }
}
