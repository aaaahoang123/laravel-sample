<?php


namespace HoangDo\Notification\Command;


use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseMigrationCommand extends Command
{
    protected $name = 'notification:migrations';

    protected $description = 'Generate migrations for notifications';

    public function handle()
    {
        $now = Carbon::now()->format('Y_m_d_His');
        $token_migrations = file_get_contents(__DIR__ . '/../../resources/migrations/create_notify_tokens_table.php');
        file_put_contents(database_path('migrations/'
            . $now
            . '_create_notify_tokens_table.php'), $token_migrations);
//        2020_07_01_114530_  H:i:s d/m/Y
        $notifications_migration = file_get_contents(__DIR__ . '/../../resources/migrations/create_notifications_table.php');
        file_put_contents(database_path('migrations/'
            . $now
            . '_create_notifications_table.php'), $notifications_migration);

        $this->info('Database migrations generated!');
    }
}
