<?php


namespace HoangDo\Authorization\Repository;

use App\User;
use HoangDo\Common\Repository\Repository;

interface PolicyRepository extends Repository
{
    /**
     * @param $role
     * @param $user_id
     * @return boolean
     */
    public function existsPolicyOfRoleAndUser($role, $user_id);

    /**
     * @param $user_id
     * @return boolean
     */
    public function userHasAdminPolicy($user_id);
}
