<?php


namespace App\Providers;


use App\Repositories\Contract\ArticleRepository;
use App\Repositories\Contract\BannerRepository;
use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Contract\ContactMessageRepository;
use App\Repositories\Contract\CustomerRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\TagRepository;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\BannerRepositoryEloquent;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use App\Repositories\Eloquent\ContactMessageRepositoryEloquent;
use App\Repositories\Eloquent\CustomerRepositoryEloquent;
use App\Repositories\Eloquent\ProductRepositoryEloquent;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryRepository::class => CategoryRepositoryEloquent::class,
        ProductRepository::class => ProductRepositoryEloquent::class,
        TagRepository::class => TagRepositoryEloquent::class,
        ArticleRepository::class => ArticleRepositoryEloquent::class,
        BannerRepository::class => BannerRepositoryEloquent::class,
        CustomerRepository::class => CustomerRepositoryEloquent::class,
        ContactMessageRepository::class => ContactMessageRepositoryEloquent::class,
        UserRepository::class => UserRepositoryEloquent::class,
    ];
}
