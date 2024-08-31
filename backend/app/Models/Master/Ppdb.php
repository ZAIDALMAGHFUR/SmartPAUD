<?php

namespace App\Models\Master;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ppdb extends Model
{
    use HasFactory;

    protected $table = 'ppdb';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'namalengkap',
        'agama_id',
        'jeniskelamin_id',
        'tgllahir',
        'tempatlahir',
        'alamat',
        'jalurpendaftaran_id',
        'tahunajaran_id',
        'jenjangpendidikan_id',
        'jurusan_id',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'asalsekolah',
        'nohp',
        'email',
        'namaayah',
        'namaibu',
        'nohpayah',
        'nohpibu',
        'pekerjaanayah',
        'pekerjaanibu',
        'alamatortu',
        'rt',
        'rw',
        'kodepos',
        'nokk',
        'noktp',
        'statuspendaftaran_id',
        'keterangan',
        'photo',
        'noinduk',
        'nopendaftaran',
        'users_id'
    ];

    public function Users()
    {
        return $this->belongsTo(Users::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function jeniskelamin()
    {
        return $this->belongsTo(Jeniskelamin::class);
    }

    public function jalurpendaftaran()
    {
        return $this->belongsTo(Jalurpendaftaran::class);
    }

    public function tahunajaran()
    {
        return $this->belongsTo(Tahunajaran::class);
    }

    public function jenjangpendidikan()
    {
        return $this->belongsTo(Jenjangpendidikan::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

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

    public function statuspendaftaran()
    {
        return $this->belongsTo(Statuspendaftaran::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->nopendaftaran = self::generateNopendaftaran();
        });
    }

    private static function generateNopendaftaran()
    {
        $prefix = date('Ymd');
        $lastRecord = self::where('nopendaftaran', 'like', $prefix . '%')->orderBy('nopendaftaran', 'desc')->first();

        $lastNumber = $lastRecord ? intval(substr($lastRecord->nopendaftaran, 8)) : 0;

        return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
