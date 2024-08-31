<?php

namespace App\Models\Master;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orangtua';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'users_id',
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
        'tgllahir',
        'tempatlahir',
        'agama_id',
        'jeniskelamin_id',
        'golongandarah_id',
        'warganegara_id',
        'photo',
        'pekerjaan_id',
        'pendidikan_id',
        'penghasilan',
        'hubungankeluarga_id',
        'no_kk',
        'no_ktp',
        'no_kis',
        'no_kks',
        'no_kps',
        'no_kip',
        'siswa_id',
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

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function hubunganKeluarga()
    {
        return $this->belongsTo(HubunganKeluarga::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function Users()
    {
        return $this->belongsTo(Users::class);
    }
}
