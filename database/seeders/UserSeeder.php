<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use HoangDo\Common\Enum\CommonStatus;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'Admin',
            'email' => 'hoangdo.2194@gmail.com',
            'password' => Hash::make('67890123'),
            'username' => 'admin',
            'status' => CommonStatus::ACTIVE
        ]);
    }
}
