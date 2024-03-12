<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use App\Http\Resources\ClubResource;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    use GeneralTrait;
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
        $sport_id = Sport::where("uuid",$request->sport)->firstOrFail()->id;
        return $this->apiResponse(ClubResource::collection(Club::where("sport_id",$sport_id)->get()));
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
    public function store(StoreClubRequest $request)
    {
        try{
        $sport_id = Sport::where("uuid",$request->sport_id)->firstOrFail()->id;
        $data = Club::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "address" => $request->address,
            "logo" => $this->uploadImagePublic($request,"club","clubs","logo"),
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
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClubRequest $request)
    {
        try{
        $club = Club::where("uuid",$request->club_id)->firstOrFail();
        $club->logo = $this->uploadImagePublic($request,"club","clubs","logo");
        
        $data = $club->save();

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
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        //
    }
}
