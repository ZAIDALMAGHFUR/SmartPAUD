<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Master\PpdbPembayaran;

class PpdbPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ppdbPembayaran = [
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'ppdb_id' => 1,
                'jenispembayaran_id' => 1,
                'statuspembayaran_id' => 1,
                'tglbayar' => now(),
                'jumlah' => 500000,
                'keterangan' => 'Pembayaran biaya pendaftaran',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'ppdb_id' => 2,
                'jenispembayaran_id' => 2,
                'statuspembayaran_id' => 1,
                'tglbayar' => now(),
                'jumlah' => 150000,
                'keterangan' => 'Pembayaran SPP bulan pertama',
            ],
            [
                'kdprofile' => '1',
                'statusenabled' => true,
                'ppdb_id' => 3,
                'jenispembayaran_id' => 3,
                'statuspembayaran_id' => 2,
                'tglbayar' => now(),
                'jumlah' => 2000000,
                'keterangan' => 'Pembayaran uang bangunan',
            ],
        ];

        PpdbPembayaran::insert($ppdbPembayaran);
    }
}
