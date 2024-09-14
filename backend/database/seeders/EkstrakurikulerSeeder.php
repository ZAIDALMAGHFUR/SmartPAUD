<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ekstrakurikulers = [
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Pramuka'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Paskibra'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Rohis'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'PMR'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'OSIS'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Basket'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Futsal'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Volly'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Bola Kaki'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Bola Tangan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Bulu Tangkis'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Tenis Meja'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Tenis Lapangan'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Karate'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Taekwondo'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Silat'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Seni Tari'],
            ['kdprofile' => '1', 'statusenabled' => 1, 'nama' => 'Seni Lukis'],
        ];

        foreach ($ekstrakurikulers as $ekstrakurikuler) {
            \App\Models\Master\Ekstrakurikuler::create($ekstrakurikuler);
        }
    }
}
