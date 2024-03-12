<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use App\Models\Matche;
use App\Models\Player;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePlanRequest extends FormRequest
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
            "player_id" => "required|string|min:10|max:40|exists:players,uuid",
            "matche_id" => "required|string|min:10|max:40|exists:matches,uuid",
            "status" => "required|string|in:main,beanch",
        ];
    }

    public function isSameSport($matche,$player){
        $cid = $matche->club1_id;
        $s1 = $player->sport_id;
        $s2 = Club::where("id",$cid)->first()->sport_id;
        return ($s1 == $s2);
    }
    public function isFinished($matche){
        return $matche->status == "finished";
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
