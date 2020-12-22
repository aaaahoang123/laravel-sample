<?php


namespace HoangDo\Notification\Provider;


use HoangDo\Notification\Command\DatabaseMigrationCommand;
use HoangDo\Notification\Controller\AdminController;
use HoangDo\Notification\Middleware\NotifyTokenMiddleware;
use HoangDo\Notification\Repository\NotificationRepository;
use HoangDo\Notification\Repository\NotificationRepositoryEloquent;
use HoangDo\Notification\Repository\NotifyTokenRepository;
use HoangDo\Notification\Repository\NotifyTokenRepositoryEloquent;
use HoangDo\Notification\Service\NotifyService;
use HoangDo\Notification\Service\NotifyServiceImpl;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public $singletons = [
        NotifyTokenRepository::class => NotifyTokenRepositoryEloquent::class,
        NotificationRepository::class => NotificationRepositoryEloquent::class,

        NotifyService::class => NotifyServiceImpl::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../resources/config/notification.php' => config_path('notification.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../resources/config/notification.php', 'notification');

        $this->app['router']->aliasMiddleware('notify_token', NotifyTokenMiddleware::class);

        $this->commands(DatabaseMigrationCommand::class);
    }

    public function register()
    {
        include __DIR__ . '/../routes.php';
//        $this->app->make(AdminController::class);
    }
}
