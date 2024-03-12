<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplacmentRequest;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use App\Models\Replacment;
use App\Http\Resources\ReplacementResource;
use App\Models\Matche;
use App\Models\Player;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class ReplacmentController extends Controller
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
        return ReplacementResource::collection($request->my_matche->replacements);
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
    public function store(StoreReplacmentRequest $request)
    {
        try{
        $inplayer = Player::where("uuid",$request->inplayer_id)->firstOrFail();
        $outplayer = Player::where("uuid",$request->outplayer_id)->firstOrFail();
        $matche = Matche::where("uuid",$request->matche_id)->firstOrFail();

        if(!$request->isFinished($matche))
         return $this->requiredField(message("يجب أن تكون المباراة منتهية "));

        if(!$request->isBeanch($matche,$inplayer))
         return $this->requiredField(message("اللاعب الداخل من المفترض أن يكون احتياط"));

        if(!$request->isMain($matche,$outplayer))
        return $this->requiredField(message("اللاعب الخارج من المفترض أن يكون أساسي"));

        $data = Replacment::create([
            "uuid" => Str::uuid(),
            "inplayer_id" => $inplayer->id,
            "outplayer_id" => $outplayer->id,
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
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function show(Replacment $replacment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Replacment $replacment)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Replacment $replacment)
    {
        //
    }
}
