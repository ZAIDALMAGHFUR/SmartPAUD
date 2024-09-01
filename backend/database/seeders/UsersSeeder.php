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
            ],
            [
                'username' => 'AhmadFauzi',
                'password' => bcrypt('AhmadFauzi'),
                'email' => 'AhmadFauzi@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah1',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'NadiaPutri',
                'password' => bcrypt('NadiaPutri'),
                'email' => 'NadiaPutri@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah2',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'RianNugraha',
                'password' => bcrypt('RianNugraha'),
                'email' => 'RianNugraha@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah3',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb4',
                'password' => bcrypt('ppdb4'),
                'email' => 'ppdb4@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah4',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb5',
                'password' => bcrypt('ppdb5'),
                'email' => 'ppdb5@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah5',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb6',
                'password' => bcrypt('ppdb6'),
                'email' => 'ppdb6@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah6',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb7',
                'password' => bcrypt('ppdb7'),
                'email' => 'ppdb7@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah7',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb8',
                'password' => bcrypt('ppdb8'),
                'email' => 'ppdb8@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah8',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb9',
                'password' => bcrypt('ppdb9'),
                'email' => 'ppdb9@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah9',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ],
            [
                'username' => 'ppdb10',
                'password' => bcrypt('ppdb10'),
                'email' => 'ppdb10@gmail.com',
                'first_name' => 'PPDB',
                'last_name' => 'Sekolah10',
                'roles_id' => 16,
                'is_active' => true,
                'is_verified' => true,
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
