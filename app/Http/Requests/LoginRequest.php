<?php

namespace App\Http\Requests;

use HoangDo\Common\Request\ValidatedRequest;

class LoginRequest extends ValidatedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ];
    }
}
