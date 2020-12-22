<?php


namespace HoangDo\Common\Request;


use HoangDo\Common\Helper\Utils;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

abstract class ValidatedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules(): array;

    protected function failedValidation(Validator $validator)
    {
        if (request()->expectsJson()) {
            $response = response()->json([
                'status' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()->toArray()
            ], 400);
            throw new HttpResponseException($response);
        }
        parent::failedValidation($validator);
    }

    public function authorize()
    {
        return true;
    }

    public function filteredData() {
        return Utils::filterData($this->all());
    }
}
