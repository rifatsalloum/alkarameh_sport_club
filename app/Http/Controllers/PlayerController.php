<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerResource;
use App\Models\Sport;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
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
            return $this->apiResponse(PlayerResource::collection(Player::all()));
        }catch(\Exception $e){
            return $this->notFoundResponse(message());
        }
    }
    public function defence(){
        try{
        return PlayerResource::collection(Player::where(function($query){
            $query->where("play","LB")->orWhere("play","CB")->orWhere("play","RB");
        })->get());
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    public function attak(){
        try{
        return PlayerResource::collection(Player::where(function($query){
            $query->where("play","LW")->orWhere("play","CF")->orWhere("play","RW");
        })->get());
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    public function middle(){
        try{
        return PlayerResource::collection(Player::where(function($query){
            $query->where("play","LM")->orWhere("play","DM")->orWhere("play","CM")->orWhere("play","AM")->orWhere("play","RM");
        })->get());
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    public function goalKeepers(){
        try{
        return PlayerResource::collection(Player::where("play","GK")->get());
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
    public function store(StorePlayerRequest $request)
    {
        try{
        $sport_id = Sport::where("uuid",$request->sport_id)->firstOrFail()->id;
        $data = Player::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,	
            "high" => $request->high,
            "play" => $request->play,
            "number" => $request->number,
            "born" => $request->born,
            "from" => $request->from,
            "first_club" => $request->first_club,
            "career" => $request->career,
            "image" => $this->uploadImagePublic($request,"player","players"),
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
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try{
        if(!isset($request->player))
          return $this->requiredField(message("You Should Give Me Player id"));
       
          return $this->apiResponse(PlayerResource::make(Player::where("uuid",$request->player)->firstOrFail()));
        }catch(\Exception $e){
            return $this->notFoundResponse(message());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerRequest $request)
    {
        try{
        $player = $request->player;
        $player->play = $request->play;
        $player->number = $request->number;
        $player->career = $request->career;
        $this->deleteImage($player->image);
        $player->image = $this->uploadImagePublic($request,"player","players");

        $data = $player->save();

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
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
