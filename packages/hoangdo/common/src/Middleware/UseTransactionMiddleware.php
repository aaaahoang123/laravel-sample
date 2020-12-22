<?php


namespace App\Http\Middleware;


use Closure;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class UseTransactionMiddleware
{
    /**
     * @param Request $req
     * @param Closure $next
     * @throws Throwable
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        DB::beginTransaction();

        $response = $next($req);

        empty($response->exception)
            ? DB::commit()
            : DB::rollBack();

        return $response;
    }
}
