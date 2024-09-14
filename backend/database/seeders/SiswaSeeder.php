<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            \App\Models\Master\Siswa::create([
                'kdprofile' => 1,
                'statusenabled' => $faker->boolean(),
                'users_id' => $faker->numberBetween(26, 51),
                'namalengkap' => $faker->name,
                'namapenggilan' => $faker->firstName,
                'nisn' => \App\Models\Master\Siswa::generateNisn(),
                'nis' => \App\Models\Master\Siswa::generateNis(),
                'nik' => $faker->unique()->numberBetween(1000000000000000, 9999999999999999),
                'email' => $faker->unique()->safeEmail,
                'jeniskelamin_id' => $faker->numberBetween(1, 3),
                'statussiswa_id' => $faker->numberBetween(1, 3),
                'provinsi_id' => $faker->numberBetween(1, 34),
                'kabupaten_id' => $faker->numberBetween(1, 500),
                'kecamatan_id' => $faker->numberBetween(1, 1000),
                'kelurahan_id' => $faker->numberBetween(1, 1000),
                'tempatlahir' => $faker->city,
                'tanggallahir' => $faker->date(),
                'agama_id' => $faker->numberBetween(1, 6),
                'warganegara_id' => $faker->numberBetween(1, 2),
                'saudarakandung' => $faker->numberBetween(0, 5),
                'saudaratiri' => $faker->numberBetween(0, 5),
                'saudaraangkat' => $faker->numberBetween(0, 3),
                'bahasaseharihari' => $faker->languageCode,
                'beratbadan' => $faker->randomFloat(2, 30, 100),
                'tinggibadan' => $faker->randomFloat(2, 100, 200),
                'golongandarah_id' => $faker->numberBetween(1, 4),
                'penyakitpernahdiderita' => $faker->word(),
                'alamatrumah' => $faker->address,
                'nohandphone' => $faker->phoneNumber,
                'statustempattinggal_id' => $faker->numberBetween(1, 3),
                'jaraktempattinggalkesekolah' => $faker->randomFloat(2, 0.5, 50),
                'namaayah' => $faker->name('male'),
                'namaibu' => $faker->name('female'),
                'pendidikan_ayah_id' => $faker->numberBetween(1, 5),
                'pendidikan_ibu_id' => $faker->numberBetween(1, 5),
                'pekerjaan_ayah_id' => $faker->numberBetween(1, 10),
                'pekerjaan_ibu_id' => $faker->numberBetween(1, 10),
                'namawali' => $faker->name,
                'pendidikan_wali_id' => $faker->numberBetween(1, 5),
                'hubunganwali_id' => $faker->numberBetween(1, 5),
                'pekerjaan_wali_id' => $faker->numberBetween(1, 10),
                'foto' => $faker->imageUrl(),
                'asalpesertadidik' => $faker->company,
                'namalembaga' => $faker->company,
                'alamatlembaga' => $faker->address,
                'namalembagapindah' => $faker->company,
                'alamatlembagaasal' => $faker->address,
                'daritingkatkelompokumur' => $faker->word(),
                'padatanggal' => $faker->date(),
                'kelompokumur' => $faker->word(),
                'tahunajaran_id' =>  $faker->numberBetween(1, 3),
                'notanggalsuratketerangan' => $faker->word(),
                'melanjutkelembaga' => $faker->company,
                'pindahlembagadarikelompokumur' => $faker->word(),
                'pindahkelembaga' => $faker->company,
                'pindahlembagatingkatkelompokumur' => $faker->word(),
                'pindahlembagapadatanggal' => $faker->date(),
                'keluarlembagapadatanggal' => $faker->date(),
                'sebabdanalasankeluarlembaga' => $faker->sentence(),
                'catatanpenting' => $faker->sentence(),
            ]);
        }
    }
}
