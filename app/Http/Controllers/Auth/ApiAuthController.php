<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $req): array
    {
        $token = auth()->attempt($req->only(['username', 'password']));
        if (!$token) {
            throw new BadRequestHttpException(__('auth.failed'));
        }
        return [
            'user' => auth()->user(),
            'token' => $token
        ];
    }
}
