<?php


namespace HoangDo\Authorization\Request;


use HoangDo\Common\Request\AuthorizedRequest;
use HoangDo\Common\Request\ValidatedRequest;

/**
 * Class PolicyRequest
 * @package HoangDo\Authorization\Request
 *
 * @property-read string $name
 * @property-read array|string[] $roles
 */
class PolicyRequest extends ValidatedRequest
{
    use AuthorizedRequest;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max: 255'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'max:500', 'exists:roles,id']
        ];
    }
}
