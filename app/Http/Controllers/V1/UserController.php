<?php
/**
 * @Author Hoang Do
 * @Created 1/8/21 3:01 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Contract\UserService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function index(Request $req): array
    {
        $pageData = $this->userService->listAll($req->query(), $req->query('limit') ?? 20);
        return [
            'datas' => $pageData->items(),
            'meta' => Utils::getMeta($pageData)
        ];
    }

    public function store(UserRequest $request)
    {
        return $this->userService->create($request);
    }

    public function show($id)
    {
        return $this->userService->single($id);
    }

    public function update(UserRequest $request, $id)
    {
        return $this->userService->edit($id, $request);
    }

    public function destroy($id)
    {
        return $this->userService->delete($id);
    }
}
