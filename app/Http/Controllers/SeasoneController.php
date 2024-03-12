<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasoneRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Seasone;
use Illuminate\Http\Request;
use App\Http\Resources\SeasoneResource;
use Illuminate\Support\Str;

class SeasoneController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        return $this->apiResponse(SeasoneResource::collection(Seasone::all()));
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
    public function store(StoreSeasoneRequest $request)
    {
        try{
        $data = Seasone::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
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
     * @param  \App\Models\Seasone  $seasone
     * @return \Illuminate\Http\Response
     */
    public function show(Seasone $seasone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seasone  $seasone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Seasone $seasone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seasone  $seasone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seasone $seasone)
    {
        //
    }
}
