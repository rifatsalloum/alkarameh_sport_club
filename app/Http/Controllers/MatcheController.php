<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Resources\MatcheResource;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReplacmentController;
use App\Http\Requests\StoreMatcheRequest;
use App\Http\Requests\UpdateMatcheRequest;
use App\Models\Club;
use App\Models\Seasone;
use App\Models\Sport;
use Carbon\Carbon;
use Illuminate\Support\Str;
class MatcheController extends Controller
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
    public function finishedMatches(Request $request){
        try{
          if(!isset($request->sport))
           return $this->requiredField(message("You Should Give Me Sport id"));

        $sport_id = Sport::where("uuid",$request->sport)->firstOrFail()->id;
        $seasone_id = Seasone::orderBy("start_date","desc")->firstOrFail()->id;

        $football = Matche::query()->whereHas("firstClub",function ($query) use ($sport_id){
            $query->where("sport_id",$sport_id);
        })->where("status","finished")->where("seasone_id",$seasone_id)->orderBy("when","desc")->get();
        
        return $this->apiResponse([
            "football"=> MatcheResource::collection($football),
        ]);
    }catch(\Exception $e){
        return $this->notFoundResponse(message());
    }
    }
    public function notStartedMatches(Request $request){
        try{
            if(!isset($request->sport))
           return $this->requiredField(message("You Should Give Me Sport id"));

        $sport_id = Sport::where("uuid",$request->sport)->firstOrFail()->id;
        $seasone_id = Seasone::orderBy("start_date","desc")->firstOrFail()->id;
        if(!$request->dashboard){
         $football = Matche::query()->whereHas("firstClub",function ($query) use ($sport_id){
            $query->where("sport_id",$sport_id);
         })->where("status","not_started")->where("seasone_id",$seasone_id)->where("when",">",Carbon::now())->orderBy("when")->get();
        }
        else{
            $football = Matche::query()->whereHas("firstClub",function ($query) use ($sport_id){
                $query->where("sport_id",$sport_id);
             })->where("status","not_started")->where("seasone_id",$seasone_id)->orderBy("when")->get();
        }
        return $this->apiResponse([
            "football"=> MatcheResource::collection($football),
        ]);
    }catch(\Exception $e){
        return $this->notFoundResponse(message());
    }
    }
    public function nextMatche(Request $request){
        try{
            if(!isset($request->sport))
           return $this->requiredField(message("You Should Give Me Sport id"));

        $sport = Sport::where("uuid",$request->sport)->firstOrFail();
        $sport_id = $sport->id;

        $player = player::where("sport_id",$sport_id)->get();
        
        $player = $player->random();
        $request["im"] = $player;
        
        $football = Matche::query()->whereHas("firstClub",function ($query) use ($sport_id){
            $query->where("sport_id",$sport_id);
        })->where("status","not_started")->where("when",">",Carbon::now())->orderBy("when")->firstOrFail();

        return $this->apiResponse(MatcheResource::make($football));
    }catch(\Exception $e){
        return $this->notFoundResponse(message());
    }
    }
    public function matcheDetails(Request $request){
        try{
        if(!isset($request->matche))
         return $this->requiredField(message("You Should Give Me Matche id"));
        
        $plan = new PlanController;
        $replacement = new ReplacmentController;

        $request["my_matche"] = Matche::where("uuid",$request->matche)->firstOrFail();

        if($request->my_matche->status == "not_started")
          return $this->requiredField(message("لايوجد تفاصيل لمباريات لم تبدأ بعد"));

        return $this->apiResponse([
            "beanched" =>$plan->getBeanchedPlayers($request),
            "replacments" => $replacement->index($request),
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
    public function store(StoreMatcheRequest $request)
    {
        try{
        $seasone_id = $request->seasone->id;
        $club1 = Club::where("uuid",$request->club1_id)->firstOrFail();
        $club2 = Club::where("uuid",$request->club2_id)->firstOrFail();

        if(!$request->isSameSport($club1,$club2))
         return $this->requiredField(message("لايمكن أن يتواجه ناديان لايلعبان نفس الرياضة"));

        $data = Matche::create([
            "uuid" => Str::uuid(),
            "when" => $request->when,
            "status" => $request->status,
            "plan" => ($request->status == "finished")? $this->uploadImagePublic($request,"plan","plans","plan") : "null",
            "channel" => $request->channel,
            "round" => $request->round,
            "play_ground" => $request->play_ground,
            "seasone_id" => $seasone_id,
            "club1_id" => $club1->id,
            "club2_id" => $club2->id
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
     * @param  \App\Models\Matche  $matche
     * @return \Illuminate\Http\Response
     */
    public function show(Matche $matche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matche  $matche
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMatcheRequest $request)
    {
        try{
        $matche = $request->matche;

        if(!$request->isNotStarted())
         return $this->requiredField(message("لايمكن تحديث معلومات مباريات منتهية"));

        $matche->when = $request->when; 
        $matche->status = $request->status;
        $matche->plan = ($request->status == "finished")? $this->uploadImagePublic($request,"plan","plans","plan") : "null";
        
        $data = $matche->save();

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
     * @param  \App\Models\Matche  $matche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matche $matche)
    {
        //
    }
}
