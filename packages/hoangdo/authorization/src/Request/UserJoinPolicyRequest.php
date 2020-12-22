<?php


namespace HoangDo\Authorization\Request;


use HoangDo\Common\Request\AuthorizedRequest;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserJoinPolicyRequest
 * @package HoangDo\Authorization\Request
 *
 * @property-read string $user_id
 * @property-read int $policy_id
 */
class UserJoinPolicyRequest extends ValidatedRequest
{
    use AuthorizedRequest;

    public function rules(): array
    {
        $clazz = config('authorization.user');
        /** @var Model $user */
        $user = new $clazz;
        $user_table = $user->getTable();
        return [
            'user_id' => ['required', 'string', "exists:$user_table,id"],
            'policy_id' => ['required', 'numeric', 'exists:policies,id']
        ];
    }
}
