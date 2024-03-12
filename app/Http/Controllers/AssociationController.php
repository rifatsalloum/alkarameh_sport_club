<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationRequest;
use App\Http\Requests\UpdateAssociationRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Association;
use Illuminate\Http\Request;
use App\Http\Resources\AssociationResource;
use App\Models\Sport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AssociationController extends Controller
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
        return $this->apiResponse(AssociationResource::collection(Association::all()));
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
    public function store(StoreAssociationRequest $request)
    {
        try{
        $sport_id = Sport::where("uuid",$request->sport_id)->firstOrFail()->id;
        $data = Association::create([
            "uuid" => Str::uuid(),
            "boss" => $request->boss,
            "image" => $this->uploadImagePublic($request,"association","associations"),
            "description"=> $request->description,
            "country" => $request->country,
            "sport_id" => $sport_id,
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
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function show(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssociationRequest $request)
    {
        try{
        $association = $request->assoc;
        $this->deleteImage($association->image);
        $association->image = $this->uploadImagePublic($request,"association","associations");
        $association->boss = $request->boss;
        $association->description = $request->description;

        $data = $association->save();

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
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function destroy(Association $association)
    {
        //
    }
}
