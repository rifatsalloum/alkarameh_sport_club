<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBossRequest;
use App\Http\Requests\UpdateBossRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Boss;
use Illuminate\Http\Request;
use App\Http\Resources\BossResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
class BossController extends Controller
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
        return BossResource::collection(Boss::all());
        }catch(\Exception $e){
            throw new HttpResponseException($this->notFoundResponse(message()));
        }
    }
    public function currentBoss(){
        try{
        return BossResource::make(Boss::orderBy("start_year","desc")->firstOrFail());
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
    public function store(StoreBossRequest $request)
    {
        try{
        $data = Boss::create([
            "uuid"=>Str::uuid(),
            "name"=>$request->name,
            "start_year"=>$request->start_year,
            "image"=>$this->uploadImagePublic($request,"boss","bosses"),
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
     * @param  \App\Models\Boss  $boss
     * @return \Illuminate\Http\Response
     */
    public function show(Boss $boss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boss  $boss
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBossRequest $request)
    {
        try{
        $boss = Boss::where("uuid",$request->boss_id)->firstOrFail();
        $this->deleteImage($boss->image);
        $boss->image = $this->uploadImagePublic($request,"boss","bosses");

        $data = $boss->save();
        
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
     * @param  \App\Models\Boss  $boss
     * @return \Illuminate\Http\Response
     */
    public function destroy(Boss $boss)
    {
        //
    }
}
