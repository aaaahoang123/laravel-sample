<?php

namespace App\Providers;

use App\Services\Contract\CategoryService;
use App\Services\Impl\CategoryServiceImpl;
use DB;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryService::class => CategoryServiceImpl::class
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
