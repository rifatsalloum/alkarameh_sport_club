<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use App\Models\Association;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAssociationRequest extends FormRequest
{
    use GeneralTrait;
    public $assoc;
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
            "association_id" => "required|string|min:10|max:40|exists:associations,uuid",
            "image" => "required|image|mimes:jpeg,jpg,png",
            "boss" => "required|string|min:3|max:255|not_regex:/^.*[0-9]+.*$/|unique:associations,boss," . ($this->assoc = Association::where("uuid",$this->association_id)->firstOrFail())->id,
            "description"=> "required|string|min:10|max:255"
        ];
    }catch(\Exception $e){
        throw new HttpResponseException($this->notFoundResponse(message()));
    }
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
