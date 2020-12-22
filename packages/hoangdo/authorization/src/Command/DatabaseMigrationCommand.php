<?php


namespace HoangDo\Authorization\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseMigrationCommand extends Command
{
    protected $name = 'make:authorization';

    protected $description = 'Generate migrations for authorization';

    public function handle()
    {
        $now = Carbon::now()->format('Y_m_d_His');
        $roles_migration = file_get_contents(__DIR__ . '/../../resources/migrations/create_roles_table.php');
        file_put_contents(database_path('migrations/'
            . $now
            . '_create_roles_table.php'), $roles_migration);
//        2020_07_01_114530_  H:i:s d/m/Y
        $policy = file_get_contents(__DIR__ . '/../../resources/migrations/create_policies_table.php');
        file_put_contents(database_path('migrations/'
            . $now
            . '_create_policies_table.php'), $policy);

        $roles_seeder = file_get_contents(__DIR__ . '/../../resources/seeder/AuthorizationRolesSeeder.php');
        file_put_contents(database_path('seeds/AuthorizationRolesSeeder.php'), $roles_seeder);

        $this->info('Authorization database migrations generated!');
    }
}
