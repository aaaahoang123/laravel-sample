<?php


namespace App\Providers;


use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Eloquent\CategoryRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CategoryRepository::class => CategoryRepositoryEloquent::class
    ];
}
