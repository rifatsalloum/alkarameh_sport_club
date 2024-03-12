<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrimeRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Prime;
use Illuminate\Http\Request;
use App\Http\Resources\PrimeResource;
use App\Models\Seasone;
use App\Models\Sport;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class PrimeController extends Controller
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
        return PrimeResource::collection(Prime::all());
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
    public function store(StorePrimeRequest $request)
    {
        try{
        $seasone_id = Seasone::where("uuid",$request->seasone_id)->firstOrFail()->id;
        $sport_id = Sport::where("uuid",$request->sport_id)->firstOrFail()->id;
        $data = Prime::create([
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "description" => $request->description,
            "image" => $this->uploadImagePublic($request,"prime","primes"),
            "type" => $request->type,
            "seasone_id" => $seasone_id,
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
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function show(Prime $prime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prime $prime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prime $prime)
    {
        //
    }
}
