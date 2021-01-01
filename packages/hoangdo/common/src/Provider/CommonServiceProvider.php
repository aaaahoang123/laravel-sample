<?php


namespace HoangDo\Common\Provider;


use DB;
use HoangDo\Common\Middleware\LanguageResolverMiddleware;
use HoangDo\Common\Middleware\ResponseJsonMiddleware;
use HoangDo\Common\Middleware\UseTransactionMiddleware;
use Illuminate\Support\ServiceProvider;
use Log;

class CommonServiceProvider extends ServiceProvider
{
    public function boot() {
        $this->app['router']->aliasMiddleware('json', ResponseJsonMiddleware::class);
        $this->app['router']->aliasMiddleware('transaction', UseTransactionMiddleware::class);
        $this->app['router']->aliasMiddleware('language', LanguageResolverMiddleware::class);

        if (config('app.debug')) {
            DB::listen(function($query) {
                Log::info(
                    $query->sql,
                    [
                        'bindings' => implode(',', $query->bindings),
                        'times' => $query->time
                    ]
                );
            });
        }
    }
}
