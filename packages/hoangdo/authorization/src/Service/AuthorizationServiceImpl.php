<?php


namespace HoangDo\Authorization\Service;

use HoangDo\Authorization\Criteria\IsNotAdminCriteria;
use HoangDo\Authorization\Model\Policy;
use HoangDo\Authorization\Repository\PolicyRepository;
use HoangDo\Authorization\Request\PolicyRequest;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Criteria\WithCountRelationCriteria;
use HoangDo\Common\Criteria\WithRelationsCriteria;
use HoangDo\Common\Enum\CommonStatus;

class AuthorizationServiceImpl implements AuthorizationService
{
    /**
     * @var PolicyRepository
     */
    private PolicyRepository $policyRepo;

    public function __construct(PolicyRepository $policyRepo)
    {
        $this->policyRepo = $policyRepo;
    }

    public function userJoinPolicy($user, $policy_id)
    {
        $policy = $this->singlePolicies($policy_id);
        $policy->users()->attach($user);
        return true;
    }

    public function userOutPolicy($user, $policy_id)
    {
        $policy = $this->singlePolicies($policy_id);
        return $policy->users()->detach($user);
    }

    public function userHasRole($user, $role)
    {
        return $this->policyRepo->existsPolicyOfRoleAndUser($role, $user->id);
    }

    public function createPolicy(PolicyRequest $request)
    {
        $policy = new Policy($request->filteredData());

        /** @var Policy $policy */
        $policy = $this->policyRepo->save($policy);

        $policy->roles()->sync($request->roles);

        return $policy;
    }

    public function listPolicies()
    {
        $this->policyRepo->pushCriteria([
            HasStatusCriteria::class,
            new WithRelationsCriteria(['roles']),
            new WithCountRelationCriteria('users'),
            IsNotAdminCriteria::class
        ]);

        return $this->policyRepo->all();
    }

    public function singlePolicies($id)
    {
        $this->policyRepo->pushCriteria([
            new WithRelationsCriteria('roles'),
            IsNotAdminCriteria::class,
        ]);
        return $this->policyRepo->find($id);
    }

    public function editPolicy($id, PolicyRequest $req)
    {
        $this->singlePolicies($id);
        /** @var Policy $policy */
        $policy = $this->policyRepo->update($req->filteredData(), $id);

        $policy->roles()->sync($req->roles);

        return $policy;
    }

    public function deletePolicy($id)
    {
        $policy = $this->singlePolicies($id);
        $policy->status = CommonStatus::INACTIVE;

        return $this->policyRepo->save($policy);
    }

    public function userIsAdmin($user)
    {
        return $this->policyRepo->userHasAdminPolicy($user->id);
    }
}
