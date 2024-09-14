<?php

namespace App\Models\Master;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'users_id',
        'namalengkap',
        'namapenggilan',
        'nisn',
        'nis',
        'nik',
        'email',
        'jeniskelamin_id',
        'statussiswa_id',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'tempatlahir',
        'tanggallahir',
        'agama_id',
        'warganegara_id',
        'saudarakandung',
        'saudaratiri',
        'saudaraangkat',
        'bahasaseharihari',
        'beratbadan',
        'tinggibadan',
        'golongandarah_id',
        'penyakitpernahdiderita',
        'alamatrumah',
        'nohandphone',
        'statustempattinggal_id',
        'jaraktempattinggalkesekolah',
        'namaayah',
        'namaibu',
        'pendidikan_ayah_id',
        'pendidikan_ibu_id',
        'pekerjaan_ayah_id',
        'pekerjaan_ibu_id',
        'namawali',
        'pendidikan_wali_id',
        'hubunganwali_id',
        'pekerjaan_wali_id',
        'foto',
        'asalpesertadidik',
        'namalembaga',
        'alamatlembaga',
        'namalembagapindah',
        'alamatlembagaasal',
        'daritingkatkelompokumur',
        'padatanggal',
        'kelompokumur',
        'tahunajaran_id',
        'notanggalsuratketerangan',
        'melanjutkelembaga',
        'pindahlembagadarikelompokumur',
        'pindahkelembaga',
        'pindahlembagatingkatkelompokumur',
        'pindahlembagapadatanggal',
        'keluarlembagapadatanggal',
        'sebabdanalasankeluarlembaga',
        'catatanpenting'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function Users()
    {
        return $this->belongsTo(Users::class);
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class);
    }

    public function TahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function warganegara()
    {
        return $this->belongsTo(Warganegara::class);
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function statusSiswa()
    {
        return $this->belongsTo(StatusSiswa::class);
    }

    public function statusTempatTinggal()
    {
        return $this->belongsTo(StatusTempatTinggal::class, 'statustempattinggal_id');
    }

    public function pendidikanAyah()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_ayah_id');
    }

    public function pendidikanIbu()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_ibu_id');
    }

    public function pekerjaanAyah()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ayah_id');
    }

    public function pekerjaanIbu()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ibu_id');
    }

    public function pendidikanWali()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_wali_id');
    }

    public function hubunganWali()
    {
        return $this->belongsTo(HubunganKeluarga::class, 'hubunganwali_id');
    }

    public function pekerjaanWali()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_wali_id');
    }

    public function prestasiSiswas()
    {
        return $this->hasMany(PrestasiSiswa::class, 'siswa_id');
    }

    public function RiawayatKesehatanSiswa()
    {
        return $this->hasMany(PrestasiSiswa::class, 'siswa_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->nisn = self::generateNisn();
            $model->nis = self::generateNis();
        });
    }

    public static function generateNisn()
    {
        $year = now()->year;
        $lastNisn = self::latest('nisn')->first();
        $lastNumber = $lastNisn ? ((int) substr($lastNisn->nisn, 4)) + 1 : 1;
        return $year . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
    }

    public static function generateNis()
    {
        $year = now()->year;
        $lastNis = self::latest('nis')->first();
        $lastNumber = $lastNis ? ((int) substr($lastNis->nis, 5)) + 1 : 1;
        return $year . '9' . str_pad($lastNumber, 5, '0', STR_PAD_LEFT); // Ensure uniqueness with 5 digits
    }
}
