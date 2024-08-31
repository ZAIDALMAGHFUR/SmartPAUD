<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kdprofile' => '1',
                'statusenabled' => '1',
                'name' => 'SMK Negeri 1 Cimahi',
                'email' => 'sipond@gmail.com',
                'phone' => '022-1234567',
                'address' => 'Jl. Raya Cimahi No. 123',
                'logo' => 'smkn1cimahi.png',
                'website' => 'https://smkn1cimahi.sch.id',
                'slogan' => 'Bersama Membangun Generasi Unggul',
                'description' => 'SMK Negeri 1 Cimahi adalah sekolah menengah kejuruan yang berada di Kota Cimahi, Jawa Barat. Sekolah ini memiliki berbagai macam jurusan yang dapat dipilih oleh siswa sesuai dengan minat dan bakatnya.',
                'vision' => 'Menjadi SMK yang unggul dalam prestasi, berwawasan lingkungan, dan berjiwa wirausaha.',
                'mission' => 'Meningkatkan kualitas pendidikan dan pembelajaran.',
                'motto' => 'Bersama Membangun Generasi Unggul',
                'fax' => '022-1234567',
                'npwp' => '1234567890',
                'npsn' => '12345678'
            ]
        ];

        foreach ($data as $item) {
            \App\Models\Profile\Profile::create($item);
        }
    }
}
