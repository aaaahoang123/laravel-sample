<?php


namespace HoangDo\Authorization\Middleware;


use Closure;
use Gate;
use HoangDo\Authorization\Exception\AuthorizationException;

class HasAllRoleMiddleware
{
    public function handle($req, Closure $next, ...$roles)
    {
        $canAccess = Gate::check($roles);

        if (!$canAccess) {
            throw new AuthorizationException();
        }

        return $next($req);
    }
}
