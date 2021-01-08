<?php
/**
 * @Author Hoang Do
 * @Created 1/8/21 2:35 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Requests;


use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Validation\Rule;
use Route;

/**
 * Class UserRequest
 * @package App\Http\Requests
 *
 * @property-read string $username
 * @property-read string|null $password
 * @property-read string $name
 * @property-read string $email
 * @property-read int|null $statusM
 */
class UserRequest extends ValidatedRequest
{
    public function rules(): array
    {
        $uniqueUsernameValidator = Rule::unique('users');
        $password_validators = ['required', 'string', 'max:50', 'min:4'];
        if ($existed_user = Route::current()->parameter('user')) {
            $uniqueUsernameValidator = $uniqueUsernameValidator->ignore($existed_user);
            $password_validators[0] = 'nullable';
        }
        return [
            'username' => ['required', 'string', 'max:191', $uniqueUsernameValidator],
            'password' => $password_validators,
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:191', 'email'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())]
        ];
    }
}
