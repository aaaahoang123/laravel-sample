<?php
/**
 * @Author Hoang Do
 * @Created 1/6/21 11:50 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Requests;


use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;
use Route;

/**
 * Class CustomerRequest
 * @package App\Http\Requests
 *
 * @property-read string $name
 * @property-read string $phone_number
 * @property-read string|null $email
 * @property-read int|null $status
 */
class CustomerRequest extends ValidatedRequest
{
    public function rules(): array
    {
        $uniquePhoneValidator = Rule::unique('customers');
        if ($existed_customer = Route::current()->parameter('customer')) {
            $uniquePhoneValidator = $uniquePhoneValidator->ignore($existed_customer);
        }
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:50', $uniquePhoneValidator],
            'email' => ['nullable', 'string', 'email', 'max:191'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())]
        ];
        return array_merge($rules, $this->extraRules());
    }

    protected function extraRules(): array
    {
        return [];
    }
}
