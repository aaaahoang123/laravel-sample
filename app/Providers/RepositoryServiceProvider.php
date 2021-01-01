<?php


namespace App\Providers;


use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\TagRepository;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use App\Repositories\Eloquent\ProductRepositoryEloquent;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryRepository::class => CategoryRepositoryEloquent::class,
        ProductRepository::class => ProductRepositoryEloquent::class,
        TagRepository::class => TagRepositoryEloquent::class,
    ];
}
