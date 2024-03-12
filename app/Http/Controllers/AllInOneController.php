<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Club;

class AllInOneController extends Controller
{
    use GeneralTrait;
    public function museum(Request $request){
        try{
        $information = new InformationController;
        $boss = new BossController;
        $prime = new PrimeController;
        $video = new VideoController;
        $request["club"] = (isset($request->club))? Club::where("name",$request->club)->firstOrFail() : Club::where("name","الكرامة")->firstOrFail();
        return $this->apiResponse([
            "about_club" => $information->aboutClub($request),
            "strategies" => $information->clubStrategies($request),
            "bosses" => $boss->index($request),
            "primes" => $prime->index($request),
            "best_goals" => $video->bestGoals($request),
        ]);
    }catch(\Exception $e){
        return $this->notFoundResponse(message());
    }
    }
    public function stuff(){
        try{
        $boss = new BossController;
        $players = new PlayerController;
        $employees = new EmployeeController;
        $wears = new WearController;

        return $this->apiResponse([
            "boss"=> $boss->currentBoss(),
            "attack" => $players->attak(),
            "middle" => $players->middle(),
            "defence" => $players->defence(),
            "goal_keepers" => $players->goalKeepers(),
            "managers" => $employees->managers(),
            "coaches" => $employees->coaches(),
            "wears" => $wears->show(),
        ]);
    }catch(\Exception $e){
        return $this->notFoundResponse(message());
    }
    }
}
