<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStandingRequest extends FormRequest
{
    use GeneralTrait;
    public $club;
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
            "win" => "required|integer|min:0",
            "lose" => "required|integer|min:0",
            "draw" => "required|integer|min:0",
            "diff" => "required|integer",
            "points" => "required|integer|min:0",
            "play" => "required|integer|min:0",
            "seasone_id" => "required|string|min:10|max:40|exists:seasones,uuid",
            "club_id" => "required|string|min:10|max:40|exists:clubs,uuid"
        ];
    }
    public function checkData(){
        $this->club = Club::where("uuid",$this->club_id)->first();
        if($this->club->sport_id == 1)
         return $this->play - $this->win == ($this->lose + $this->draw)  && $this->points == ($this->win)*3 + $this->draw;
        else 
         return $this->play - $this->win == $this->lose && $this->points == ($this->win)*2 + $this->lose;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
