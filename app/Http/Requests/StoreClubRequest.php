<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreClubRequest extends FormRequest
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
            "name" => "required|string|min:3|max:255|not_regex:/^.*[0-9]+.*$/",
            "address" => "required|string|min:3|max:255",
            "logo" => "required|image|mimes:jpeg,jpg,png",
            "sport_id" => "required|string|min:10|max:40|exists:sports,uuid",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField(message(null,8,$validator->errors())));
    }
}
