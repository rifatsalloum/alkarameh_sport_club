<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Matche;
use App\Models\Seasone;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMatcheRequest extends FormRequest
{
    use GeneralTrait;
    public $matche;
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
        $x = ($this->status == "finished")? "before:" : "after:";
        $plan = ($this->status == "finished")? "required" : "nullable";
        return [
            "matche_id" => "required|string|min:10|max:40|exists:matches,uuid",
            "when" =>"required|date|after:" . ($s = Seasone::where("id",($this->matche = Matche::where("uuid",$this->matche_id)->firstOrFail())->seasone_id)->firstOrFail())->start_date . "|before:". $s->end_date ."|$x" . Carbon::now(),
            "status" => "required|string|in:not_started,finished",
            "plan" => "$plan|image|mimes:jpeg,jpg,png",
        ];
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    public function isNotStarted(){
        return ($this->matche->status == "not_started");
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
