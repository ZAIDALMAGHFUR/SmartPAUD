<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShiftKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shiftKerja = [
            [
                'kdprofile' => 1,
                'statusenabled' => 1,
                'name' => 'Shift Pagi',
                'jammasuk' => '07:00:00',
                'jampulang' => '14:00:00',
                'jambreakawal' => '10:00:00',
                'jambreakakhir' => '10:30:00',
                'factorrate' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kdprofile' => 1,
                'statusenabled' => 1,
                'name' => 'Shift Siang',
                'jammasuk' => '13:00:00',
                'jampulang' => '20:00:00',
                'jambreakawal' => '17:00:00',
                'jambreakakhir' => '17:30:00',
                'factorrate' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kdprofile' => 1,
                'statusenabled' => 1,
                'name' => 'Shift Ekstrakurikuler',
                'jammasuk' => '14:00:00',
                'jampulang' => '17:00:00',
                'jambreakawal' => '15:30:00',
                'jambreakakhir' => '16:00:00',
                'factorrate' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kdprofile' => 1,
                'statusenabled' => 1,
                'name' => 'Shift Keamanan Sekolah',
                'jammasuk' => '06:00:00',
                'jampulang' => '18:00:00',
                'jambreakawal' => '12:00:00',
                'jambreakakhir' => '12:30:00',
                'factorrate' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kdprofile' => 1,
                'statusenabled' => 1,
                'name' => 'Shift Kebersihan Sekolah',
                'jammasuk' => '06:00:00',
                'jampulang' => '14:00:00',
                'jambreakawal' => '09:00:00',
                'jambreakakhir' => '09:30:00',
                'factorrate' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($shiftKerja as $item) {
            \App\Models\Master\ShiftKerja::create($item);
        }
    }
}
