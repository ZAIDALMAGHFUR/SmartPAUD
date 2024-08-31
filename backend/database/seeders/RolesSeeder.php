<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'superadmin', // 1
            ],
            [
                'name' => 'admin', // 2
            ],
            [
                'name' => 'kepala sekolah', // 3
            ],
            [
                'name' => 'wakil kepala sekolah', // 4
            ],
            [
                'name' => 'guru', // 5
            ],
            [
                'name' => 'staff administrasi', // 6
            ],
            [
                'name' => 'kepala perpustakaan', // 7
            ],
            [
                'name' => 'pustakawan', // 8
            ],
            [
                'name' => 'staff keuangan', // 9
            ],
            [
                'name' => 'koordinator kegiatan', // 10
            ],
            [
                'name' => 'pengawas sekolah', // 11
            ],
            [
                'name' => 'siswa', // 12
            ],
            [
                'name' => 'orangtua', // 13
            ],
            [
                'name' => 'alumni', // 14
            ],
            [
                'name' => 'vendor', // 15
            ],
            [
                'name' => 'ppdb', // 16
            ]
        ];
        foreach ($roles as $role) {
            \App\Models\Roles::create($role);
        }
    }
}
