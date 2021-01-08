<?php
/**
 * @Author Hoang Do
 * @Created 1/8/21 2:29 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Impl;


use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Criteria\User\UserHasSearchCriteria;
use App\Services\Contract\UserService;
use Hash;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;

class UserServiceImpl extends SimpleService implements UserService
{
    private UserRepository $userRepo;

    public function __construct(
        UserRepository $userRepo
    )
    {
        $this->userRepo = $userRepo;
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->userRepo;
        $props->listIgnoreStatus = true;

        return $props;
    }

    protected function beforeCreate($instance, ValidatedRequest $req)
    {
        /** @var User $instance */
        $instance->password = Hash::make($req->input('password'));
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
        $password = $req->input('password');
        /** @var User $instance */
        if ($password && !Hash::check($password, $instance->password)) {
            $instance->password = Hash::make($password);
        }
    }

    protected function queryToCriteria(array $query): array
    {
        $criteria = [];

        if ($status = $query['status'] ?? null) {
            $criteria[] = new HasStatusCriteria($status);
        }

        if ($search = $query['search'] ?? null) {
            $criteria[] = new UserHasSearchCriteria($search);
        }

        return $criteria;
    }
}
