<?php


use BenSampo\Enum\Enum;
use HoangDo\Authorization\Model\Policy;
use HoangDo\Authorization\Model\Role;
use HoangDo\Authorization\Service\AuthorizationService;
use Illuminate\Database\Seeder;

class AuthorizationRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = config('authorization.roles_enum');
        /**
         * @var Enum[] $roles_instances
         * @var AuthorizationService $authService
         */
        $roles_instances = $roles::getInstances();

        foreach ($roles_instances as $roles_instance)
        {
            Role::query()->create([
                'id' => $roles_instance->value
            ]);
        }

        $policy = new Policy(['name' => 'Admin']);
        $policy->is_admin = true;
        $policy->save();
    }
}
