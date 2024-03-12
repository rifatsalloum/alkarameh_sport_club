<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Player;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePlayerRequest extends FormRequest
{
    use GeneralTrait;
    public $player;
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
        try{
        return [
            "player_id" => "required|string|min:10|max:40|exists:players,uuid",
            "play" => "required|string|in:GK,LB,CB,RB,LM,CM,AM,DM,RM,LW,CF,RW",
            "number" => "required|integer|min:1|unique:players,number," . ($this->player = Player::where("uuid",$this->player_id)->firstOrFail())->id,
            "career" => "required|string|min:5|max:255",
            "image" => "required|image|mimes:jpeg,jpg,png",
        ];
    }catch(\Exception $e)
    {
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
