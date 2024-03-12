<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class StatisticController extends Controller
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
    public function store(StoreStatisticRequest $request)
    {
        try{
        $matche = Matche::where("uuid",$request->matche_id)->firstOrFail();

        if(!$request->isFinished($matche))
          return $this->requiredField(message("يجب أن تكون المباراة منتهية"));

        if(!$request->checkKeys())
         return $this->requiredField(message("invalid keys input must be team1 and team2 only"));

        $data = Statistic::create([
            "uuid"=>Str::uuid(),
            "name" => $request->name,
            "value" => json_encode($request->value),
            "matche_id" => $matche->id
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
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatisticRequest $request)
    {
        try{
        $statistic = Statistic::where("uuid",$request->statistic_id)->firstOrFail();

        if(!$request->checkKeys())
         return $this->requiredField(message("invalid keys input must be team1 and team2 only"));

        $statistic->value = json_encode($request->value);
        $data = $statistic->save();

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
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistic $statistic)
    {
        //
    }
}
