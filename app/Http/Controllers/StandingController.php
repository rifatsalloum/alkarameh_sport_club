<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStandingRequest;
use App\Http\Requests\UpdateStandingRequest;
use App\Http\Resources\StandingResource;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use App\Models\Standing;
use Illuminate\Http\Request;
use App\Models\Seasone;
use App\Models\Sport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class StandingController extends Controller
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
        if(!isset($request->seasone) || !isset($request->sport))
          return $this->requiredField(message("You Should Give Me Seasone id and Sport id"));

        $seasone_id = Seasone::where("uuid",$request->seasone)->firstOrFail()->id;
        $sport_id = Sport::where("uuid",$request->sport)->firstOrFail()->id;

        $football = Standing::query()->whereHas("club",function ($query) use ($sport_id){
            $query->where("sport_id",$sport_id);
        })->where("seasone_id",$seasone_id)->orderBy("points","desc")->get();


        return $this->apiResponse([
            "football" => StandingResource::collection($football),
        ]);
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
    public function store(StoreStandingRequest $request)
    {
        try{

        if(!$request->checkData())
         return $this->requiredField(message("هناك خطأ تأكد من حسابات المعطيات"));

        $seasone_id = Seasone::where("uuid",$request->seasone_id)->firstOrFail()->id;
        $club_id = $request->club->id;
        $data = Standing::create([
            "uuid" => Str::uuid(),
            "win" => $request->win,
            "lose" => $request->lose,
            "draw" => $request->draw,
            "diff" => $request->diff,
            "points" => $request->points,
            "play" => $request->play,
            "seasone_id" => $seasone_id,
            "club_id" => $club_id
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
     * @param  \App\Models\Standing  $standing
     * @return \Illuminate\Http\Response
     */
    public function show(Standing $standing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Standing  $standing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStandingRequest $request)
    {
        try{
            
        if(!$request->checkData())
         return $this->requiredField(message("هناك خطأ تأكد من حسابات المعطيات"));

        $row = $request->standing;
        $row->win = $request->win;
        $row->lose = $request->lose;
        $row->draw = $request->draw;
        $row->diff = $request->diff;
        $row->points = $request->points;
        $row->play = $request->play;
        
        $data = $row->save();

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
     * @param  \App\Models\Standing  $standing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Standing $standing)
    {
        //
    }
}
