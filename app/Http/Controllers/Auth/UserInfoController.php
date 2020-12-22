<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function userData(Request $request): array {
        return [
            'user' => $request->user(),
            'token' => $request->bearerToken()
        ];
    }
}
