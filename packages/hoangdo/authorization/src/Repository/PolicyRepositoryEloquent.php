<?php


namespace HoangDo\Authorization\Repository;


use HoangDo\Authorization\Model\Policy;
use HoangDo\Common\Repository\RepositoryEloquent;
use Illuminate\Database\Eloquent\Builder;

class PolicyRepositoryEloquent extends RepositoryEloquent implements PolicyRepository
{
    public function model()
    {
        return Policy::class;
    }

    public function existsPolicyOfRoleAndUser($role, $user_id)
    {
        return $this->model->newQuery()
            ->whereHas('roles', fn(Builder $q) => $q->where('id', $role))
            ->whereHas('users', fn(Builder $q) => $q->where('id', $user_id));
    }

    public function userHasAdminPolicy($user)
    {
        $result = $this->model->newQuery()
            ->where('is_admin', true)
            ->whereHas('users', fn(Builder $q) => $q->where('id', $user));
        return $result;
    }
}
