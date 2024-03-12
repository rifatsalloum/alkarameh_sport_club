<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class sendMailRequest extends FormRequest
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
            "name" =>"required|string|min:3|max:255|not_regex:/^.*[0-9]+.*$/",
            "email"=>"required|email|ends_with:yahoo.com,hotmail.com,gmail.com|min:11|max:50",
            "number"=>"required|string|regex:/^(09)[0-9]{8}$/",
            "message"=>"required|string|min:3|max:255",
        ];
    }
    protected function failedValidation(Validator $validator)
    {      
            throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
