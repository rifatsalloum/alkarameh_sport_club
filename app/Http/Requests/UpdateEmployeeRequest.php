<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Employee;

class UpdateEmployeeRequest extends FormRequest
{
    use GeneralTrait;
    public $emp;
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
            "employee_id" => "required|string|min:10|max:40|exists:employees,uuid",
            "name" => "required|string|min:3|max:255|not_regex:/^.*[0-9]+.*$/|unique:employees,name," . ($this->emp = Employee::where("uuid",$this->employee_id)->firstOrFail())->id,
            "image" => "required|image|mimes:jpeg,jpg,png"
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
