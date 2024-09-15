<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Master\JenisProduk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            // UsersSeeder::class,
            ProfileSeeder::class,
            FromJsonSeeder::class,
            RegistrationClientSeeder::class,
            AgamaSeeder::class,
            JenisKelaminSeeder::class,
            GolonganDarahSeeder::class,
            PekerjaanSeeder::class,
            PendidikanSeeder::class,
            StatusPerkawinanSeeder::class,
            WargaNegaraSeeder::class,
            JabatanSeeder::class,
            JenisPegawaiSeeder::class,
            GolonganPegawaiSeeder::class,
            UnitKerjaSeeder::class,
            KategorypegawaiSeeder::class,
            StatusPegawaiSeeder::class,
            StatusPembayaranSeeder::class,
            KelompokpegawaiSeeder::class,
            HubunganKeluargaSeeder::class,
            ShiftKerjaSeeder::class,
            PegawaiSeeder::class,
            JenisPembayaranSeeder::class,
            StatusPendaftaran::class,
            StatusSiswaSeeder::class,
            StatusMasukSeeder::class,
            TahunAjaranSeeder::class,
            JadwalPpdbSeeder::class,
            StatusTempatTinggalSeeder::class,
            PpdbSeeder::class,
            PpdbPembayaranSeeder::class,
            SiswaSeeder::class,
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            JadwalPelajaranSeeder::class,
            PrestasiSiswaSeeder::class,
            RiawayatKesehatanSiswaSeeder::class,
            KelasSiswaSeeder::class,
            EkstrakurikulerSeeder::class,
            EkstrakurikulerSiswaSeeder::class,
            SikapSiswaSeeder::class,
            SikapSiswaTransaksiSeeder::class,
            MateriSiswaSeeder::class,
            TugasSiswaSeeder::class,
            TugasSiswaDetailSeeder::class,
            JawabanTugasSiswaSeeder::class,
            JawabanTugasSiswaDetailSeeder::class,
            AbsenSeeder::class,
        ]);
    }
}
