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
        'nisn',
        'nis',
        'namalengkap',
        'nik',
        'nohp',
        'email',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'rt',
        'rw',
        'alamat',
        'tempatlahir',
        'tgllahir',
        'anakke',
        'jmlsaudarakandung',
        'jmlsaudaratiri',
        'jmlsaudaraperempuan',
        'jmlsaudaralaki',
        'tinggibadan',
        'beratbadan',
        'jmlhafalan',
        'jmlhafalansurat',
        'jmlhafalanjuz',
        'users_id',
        'agama_id',
        'jeniskelamin_id',
        'golongandarah_id',
        'statussiswa_id',
        'photo'
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

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class);
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function warganegara()
    {
        return $this->belongsTo(Warganegara::class);
    }

    public function statusSiswa()
    {
        return $this->belongsTo(StatusSiswa::class);
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }

    public function siswaTransaksi()
    {
        return $this->hasMany(SiswaTransaksi::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->nisn = self::generateNisn();
            $model->nis = self::generateNis();
        });
    }

    private static function generateNisn()
    {
        $year = now()->year; // Menggunakan tahun saat ini
        $lastNisn = self::latest('nisn')->first();
        $lastNumber = $lastNisn ? ((int) substr($lastNisn->nisn, 4)) + 1 : 1;
        return $year . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
    }

    private static function generateNis()
    {
        $year = now()->year; // Menggunakan tahun saat ini
        $lastNis = self::latest('nis')->first();
        $lastNumber = $lastNis ? ((int) substr($lastNis->nis, 4)) + 1 : 1;
        return $year . '9' . str_pad($lastNumber, 4, '0', STR_PAD_LEFT); // Menambahkan '9' untuk membedakan
    }

}
