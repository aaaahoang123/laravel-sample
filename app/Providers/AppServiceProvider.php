<?php

namespace App\Providers;

use App\Services\Contract\ArticleService;
use App\Services\Contract\BannerService;
use App\Services\Contract\CategoryService;
use App\Services\Contract\ContactMessageService;
use App\Services\Contract\CustomerService;
use App\Services\Contract\ProductService;
use App\Services\Contract\SystemConfigService;
use App\Services\Contract\TagService;
use App\Services\Contract\UserService;
use App\Services\Impl\ArticleServiceImpl;
use App\Services\Impl\BannerServiceImpl;
use App\Services\Impl\CategoryServiceImpl;
use App\Services\Impl\ContactMessageServiceImpl;
use App\Services\Impl\CustomerServiceImpl;
use App\Services\Impl\ProductServiceImpl;
use App\Services\Impl\SystemConfigServiceImpl;
use App\Services\Impl\TagServiceImpl;
use App\Services\Impl\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryService::class => CategoryServiceImpl::class,
        ProductService::class => ProductServiceImpl::class,
        TagService::class => TagServiceImpl::class,
        ArticleService::class => ArticleServiceImpl::class,
        BannerService::class => BannerServiceImpl::class,
        ContactMessageService::class => ContactMessageServiceImpl::class,
        CustomerService::class => CustomerServiceImpl::class,
        UserService::class => UserServiceImpl::class,
        SystemConfigService::class => SystemConfigServiceImpl::class,
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
