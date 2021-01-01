<?php


namespace HoangDo\Storage;


use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    public array $singletons = [
        FileStorageService::class => FileStorageServiceImpl::class
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/config/storage.php' => config_path('storage.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../resources/config/storage.php', 'storage');
    }

    public function register()
    {
        include __DIR__ . '/routes.php';
    }
}
