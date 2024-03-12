<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmployeeRequest extends FormRequest
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
            "name" => "required|string|min:3|max:255|unique:employees,name|not_regex:/^.*[0-9]+.*$/",
            "jop_type" => "required|string|in:manager,coach",
            "work" => "required|string|unique:employees,work|not_regex:/^.*[0-9]+.*$/|min:2|max:255",
            "image" => "required|image|mimes:jpeg,jpg,png",
            "sport_id" => "required|string|min:10|max:40|exists:sports,uuid"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
