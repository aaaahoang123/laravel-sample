<?php


namespace HoangDo\Authorization\Controller;

use HoangDo\Authorization\Request\PolicyRequest;
use HoangDo\Authorization\Request\UserJoinPolicyRequest;
use HoangDo\Authorization\Service\AuthorizationService;
use Illuminate\Routing\Controller;

class PolicyManageController extends Controller
{
    private AuthorizationService $authService;

    public function __construct(AuthorizationService $authService)
    {
        $this->authService = $authService;
    }

    public function createPolicy(PolicyRequest $req)
    {
        return $this->authService->createPolicy($req);
    }

    public function listPolicies()
    {
        return $this->authService
            ->listPolicies();
    }

    public function singlePolicy($id)
    {
        return  $this->authService->singlePolicies($id);
    }

    public function editPolicy($id, PolicyRequest $req)
    {
        return $this->authService->editPolicy($id, $req);
    }

    public function deletePolicy($id)
    {
        return $this->authService->deletePolicy($id);
    }

    public function userJoinPolicy(UserJoinPolicyRequest $req)
    {
        $this->authService->userJoinPolicy($req->user_id, $req->policy_id);
        return [
            'result' => true,
        ];
    }

    public function userOutPolicy(UserJoinPolicyRequest $req)
    {
        return [
            'result' => $this->authService->userOutPolicy($req->user_id, $req->policy_id)
        ];
    }
}
