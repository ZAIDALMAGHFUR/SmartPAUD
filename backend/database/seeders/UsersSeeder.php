<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'superadmin',
                'password' => bcrypt('superadmin'),
                'email' => 'superadmin@gmail.com',
                'first_name' => 'superadmin',
                'last_name' => 'superadmin',
                'roles_id' => 1,
                'is_active' => true,
                'is_verified' => true,
                'verification_token' => null,
                'reset_token' => null,
                'reset_token_expires_at' => null,
                'last_login_at' => null,
                'last_failed_login_at' => null,
                'failed_login_count' => 0,
                'last_failed_login_ip' => null,
                'last_login_ip' => null,
                'timezone' => null,
                'locale' => null,
                'ip_address' => null,
            ],
            [
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'email' => 'admin@gmail.com',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'roles_id' => 2,
                'is_active' => true,
                'is_verified' => true,
                'verification_token' => null,
                'reset_token' => null,
                'reset_token_expires_at' => null,
                'last_login_at' => null,
                'last_failed_login_at' => null,
                'failed_login_count' => 0,
                'last_failed_login_ip' => null,
                'last_login_ip' => null,
                'timezone' => null,
                'locale' => null,
                'ip_address' => null,
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
