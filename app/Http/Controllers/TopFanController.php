<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopFanRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\TopFan;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class TopFanController extends Controller
{
    use GeneralTrait;
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
    public function store(StoreTopFanRequest $request)
    {
        try{
        $association_id = Association::where("uuid",$request->association_id)->firstOrFail()->id;
        $data = TopFan::create([
            "uuid"=>Str::uuid(),
            "name"=> $request->name,
            "association_id"=>$association_id,
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
     * @param  \App\Models\TopFan  $topFan
     * @return \Illuminate\Http\Response
     */
    public function show(TopFan $topFan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopFan  $topFan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopFan $topFan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopFan  $topFan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopFan $topFan)
    {
        //
    }
}
