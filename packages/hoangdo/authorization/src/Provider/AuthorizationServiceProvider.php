<?php


namespace HoangDo\Authorization\Provider;

use BenSampo\Enum\Enum;
use Gate;
use HoangDo\Authorization\Command\DatabaseMigrationCommand;
use HoangDo\Authorization\Helper\RoleUtils;
use HoangDo\Authorization\Middleware\HasAllRoleMiddleware;
use HoangDo\Authorization\Middleware\HasAnyRoleMiddleware;
use HoangDo\Authorization\Repository\PolicyRepository;
use HoangDo\Authorization\Repository\PolicyRepositoryEloquent;
use HoangDo\Authorization\Service\AuthorizationService;
use HoangDo\Authorization\Service\AuthorizationServiceImpl;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    public $singletons = [
        PolicyRepository::class => PolicyRepositoryEloquent::class,
        AuthorizationService::class => AuthorizationServiceImpl::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../resources/config/authorization.php' => config_path('authorization.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../resources/config/authorization.php', 'authorization');

        $this->commands(DatabaseMigrationCommand::class);

        $roles = config('authorization.roles_enum');

        /**
         * @var Enum[] $roles_instances
         * @var AuthorizationService $authService
         */
        $roles_instances = $roles::getInstances();
        $authService = $this->app->make($this->singletons[AuthorizationService::class]);

        foreach ($roles_instances as $role) {
            Gate::define($role->value, fn($user) => $authService->userHasRole($user, $role->value));
        }

        Gate::before(function ($user) use ($authService) {
            return $authService->userIsAdmin($user) ? true : null;
        });

        $this->app['router']->aliasMiddleware(RoleUtils::HAS_ALL_ROLES_ALIAS, HasAllRoleMiddleware::class);
        $this->app['router']->aliasMiddleware(RoleUtils::HAS_ANY_ROLES_ALIAS, HasAnyRoleMiddleware::class);
    }

    public function register()
    {
        include __DIR__ . '/../routes.php';
//        $this->app->make(AdminController::class);
    }
}
