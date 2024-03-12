<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Club;
use App\Models\Seasone;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class StoreMatcheRequest extends FormRequest
{
    use GeneralTrait;

    public $seasone;
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
            "seasone_id" => "required|string|min:10|max:40|exists:seasones,uuid",
            "club1_id" =>"required|string|min:10|max:40|exists:clubs,uuid",
            "club2_id" => "required|string|min:10|max:40|exists:clubs,uuid",
            "when" => "required|date|after:" . ($this->seasone = Seasone::where("uuid",$this->seasone_id)->firstOrFail())->start_date . "|before:" . $this->seasone->end_date . "|$x" . Carbon::now(),
            "status" => "required|string|in:finished,not_started",
            "plan" => "$plan|image|mimes:jpeg,jpg,png",
            "channel" => "required|string|min:3|max:255",
            "round" => "required|integer|min:1|max:100",
            "play_ground" => "required|string|min:3|max:255",
        ];
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    public function isSameSport($club1,$club2){
        return ($club1->id != $club2->id && $club1->sport_id == $club2->sport_id);
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
