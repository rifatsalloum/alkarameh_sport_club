<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Resources\PlanResource;
use App\Http\Resources\PlayerResource;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Plan;
use App\Models\Player;
use App\Models\Matche;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class PlanController extends Controller
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
    public function getBeanchedPlayers(Request $request){
        try{
        if(!isset($request->matche))
         return $this->requiredField(message("You Should Give Me Matche id"));

        $matche = (isset($request->my_matche))? $request->my_matche : Matche::where("uuid",$request->matche)->firstOrFail();

        if($matche->status == "not_started")
         return $this->requiredField(message("لايمكن وجود تشكيلة لمباراة لم تبدأ بعد"));

        $matche_id = $matche->id;

        $players =  Player::whereHas("plans",function ($query) use ($matche_id){
            $query->where("matche_id",$matche_id)->where("status","beanch");
        })->get();
        
        return (isset($request->my_matche))? PlayerResource::collection($players) : $this->apiResponse(PlayerResource::collection($players));
    }catch(\Exception $e){
        return (isset($request->my_matche))? (throw new HttpResponseException($this->notFoundResponse(message()))) : $this->notFoundResponse(message());
    }
    }
    public function getMainPlayers(Request $request){
        try{
        if(!isset($request->matche))
         return $this->requiredField(message("You Should Give Me Matche id"));

        $matche = Matche::where("uuid",$request->matche)->firstOrFail();

        if($matche->status == "not_started")
         return $this->requiredField(message("لايمكن وجود تشكيلة لمباراة لم تبدأ بعد"));
    
        $matche_id = $matche->id;

        $players =  Player::whereHas("plans",function ($query) use ($matche_id){
            $query->where("matche_id",$matche_id)->where("status","main");
        })->get();
        
        return $this->apiResponse(PlayerResource::collection($players));
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
    public function store(StorePlanRequest $request)
    {
        try{
        $player = Player::where("uuid",$request->player_id)->firstOrFail();
        $matche = Matche::where("uuid",$request->matche_id)->firstOrFail();

        if(!$request->isFinished($matche))
         return $this->requiredField(message("لايمكن ادخال التشكيلة الا في المباريات المنتهية"));

        if(!$request->isSameSport($matche,$player))
         return $this->requiredField(message("لايمكن ادخال لاعب يلعب رياضة مختلفة عن رياضة المباراة"));

        $data = Plan::create([
            "uuid" => Str::uuid(),
            "player_id" => $player->id,
            "matche_id" => $matche->id,
            "status" => $request->status
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
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
