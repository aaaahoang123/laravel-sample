<?php


namespace HoangDo\Authorization\Middleware;


use Closure;
use Gate;
use HoangDo\Authorization\Enum\BaseRole;
use HoangDo\Authorization\Exception\AuthorizationException;

class HasAnyRoleMiddleware
{
    public function handle($req, Closure $next, ...$roles)
    {
        $canAccess = Gate::any($roles);

        if (!$canAccess) {
            throw new AuthorizationException();
        }

        return $next($req);
    }

}
