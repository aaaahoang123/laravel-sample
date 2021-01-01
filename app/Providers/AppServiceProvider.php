<?php

namespace App\Providers;

use App\Services\Contract\CategoryService;
use App\Services\Contract\ProductService;
use App\Services\Contract\TagService;
use App\Services\Impl\CategoryServiceImpl;
use App\Services\Impl\ProductServiceImpl;
use App\Services\Impl\TagServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryService::class => CategoryServiceImpl::class,
        ProductService::class => ProductServiceImpl::class,
        TagService::class => TagServiceImpl::class,
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
