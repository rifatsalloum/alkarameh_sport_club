<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStatisticRequest extends FormRequest
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
            "matche_id" =>"required|string|min:10|max:40|exists:matches,uuid",
            "name" => "required|string|min:3|max:255|not_regex:/^.*[0-9]+.*$/",
            "value" => "required|array|min:2|max:2",
            "value.*" =>"required|integer|min:0|max:1000000"
        ];
    }
    public function checkKeys(){
        $keys = array_keys($this->value);
        return $keys[0] == "team1" && $keys[1] == "team2";
    }
    public function isFinished($matche){
        return $matche->status == "finished";
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
