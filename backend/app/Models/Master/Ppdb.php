<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ppdb extends Model
{
    use HasFactory;

    protected $table = 'ppdb';

    protected $fillable = [
        'statusenabled',
        'kdprofile',
        'users_id',
        'namalengkap',
        'namapanggilan',
        'jeniskelamin_id',
        'tanggallahir',
        'tempatlahir',
        'agama_id',
        'warganegara_id',
        'anaknomorke',
        'jumlahsaudarakandung',
        'jumlahsaudaratiri',
        'jumlahsaudaraangkat',
        'bahasaseharihari',
        'beratbadan',
        'tinggibadan',
        'golongandarah_id',
        'penyakitpernahdiderita',
        'alamattempattinggal',
        'nomortelepon',
        'statustempattinggal_id',
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
        'statusmasuk_id',
        'namatkasal',
        'tanggalpindahan',
        'kelompokpindahan',
        'tanggalditerima',
        'kelompokditerima',
        'statuspendaftaran_id',
        'alasanpenolakan',
        'nopendaftaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jeniskelamin_id');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function wargaNegara()
    {
        return $this->belongsTo(WargaNegara::class, 'warganegara_id');
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'golongandarah_id');
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

    public function statusMasuk()
    {
        return $this->belongsTo(StatusMasuk::class, 'statusmasuk_id');
    }

    public function statusPendaftaran()
    {
        return $this->belongsTo(StatusPendaftaran::class, 'statuspendaftaran_id');
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
