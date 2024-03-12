<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePlayerRequest extends FormRequest
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
            "name" => "required|string|min:3|max:255|unique:players,name|not_regex:/^.*[0-9]+.*$/",	
            "high" => "required|integer|min:150|max:210",
            "play" => "required|string|in:GK,LB,CB,RB,LM,CM,AM,DM,RM,LW,CF,RW",
            "number" => "required|integer|min:1|unique:players,number",
            "born" => "required|date|before_or_equal:" . Carbon::now()->subYears(18) . "|after_or_equal:" . Carbon::now()->subYears(50),
            "from" => "required|string|min:3|max:255",
            "first_club" => "required|string|min:3|max:255",
            "career" => "required|string|min:5|max:255",
            "image" => "required|image|mimes:jpeg,jpg,png",
            "sport_id" => "required|string|min:10|max:40|exists:sports,uuid"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
