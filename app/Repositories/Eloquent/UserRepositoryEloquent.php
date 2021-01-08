<?php
/**
 * @Author Hoang Do
 * @Created 1/8/21 2:32 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Contract\UserRepository;
use HoangDo\Common\Repository\RepositoryEloquent;

class UserRepositoryEloquent extends RepositoryEloquent implements UserRepository
{
    public function model()
    {
        return User::class;
    }
}
