<?php


namespace HoangDo\Authorization\Service;

use HoangDo\Authorization\Model\Policy;
use HoangDo\Authorization\Request\PolicyRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface AuthorizationService
{
    /**
     * @param string $user
     * @param $policy_id
     * @return mixed
     */
    public function userJoinPolicy($user, $policy_id);

    /**
     * @param string $user
     * @param $policy_id
     * @return mixed
     */
    public function userOutPolicy($user, $policy_id);

    /**
     * @param $user
     * @param string $role
     * @return boolean
     */
    public function userHasRole($user, $role);

    /**
     * @param PolicyRequest $request
     * @return Policy
     */
    public function createPolicy(PolicyRequest $request);

    /**
     * @return Policy[]|Collection
     */
    public function listPolicies();

    /**
     * @param $id
     * @return Policy
     * @throws ModelNotFoundException
     */
    public function singlePolicies($id);

    /**
     * @param $id
     * @param PolicyRequest $req
     * @throws  ModelNotFoundException
     * @return Policy
     */
    public function editPolicy($id, PolicyRequest $req);

    /**
     * @param $id
     * @return Policy
     * @throws ModelNotFoundException
     */
    public function deletePolicy($id);

    /**
     * @param User $user
     * @return boolean
     */
    public function userIsAdmin($user);
}
