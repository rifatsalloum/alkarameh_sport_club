<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Plan;
use App\Models\Player;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReplacmentRequest extends FormRequest
{
    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "inplayer_id" => "required|string|min:10|max:40|exists:players,uuid",
            "outplayer_id" => "required|string|min:10|max:40|exists:players,uuid",
            "matche_id" => "required|string|min:10|max:40|exists:matches,uuid",
        ];
    }
   
    public function isBeanch($matche,$inplayer){
        $pid = $inplayer->id;
        $mid = $matche->id;
        $plan = Plan::where("player_id",$pid)->where("matche_id",$mid)->first();
        if(!$plan)
         return false;
        return ($plan->status == "beanch");
    }
    public function isMain($matche,$outplayer){
        $pid = $outplayer->id;
        $mid = $matche->id;
        $plan = Plan::where("player_id",$pid)->where("matche_id",$mid)->first();
        if(!$plan)
         return false;
        return ($plan->status == "main");
    }
    public function isFinished($matche){
        return $matche->status == "finished";
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
