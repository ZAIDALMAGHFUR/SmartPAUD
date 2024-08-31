<?php

namespace App\Models\Master;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'agama_id',
        'jeniskelamin_id',
        'golongandarah_id',
        'pekerjaan_id',
        'pendidikan_id',
        'statusperkawinan_id',
        'warganegara_id',
        'namalengkap',
        'nik',
        'npwp',
        'nohp',
        'email',
        'nobpjs',
        'nopaspor',
        'nokk',
        'noasuransilain',
        'nip',
        'nosip',
        'nostr',
        'tglberakhirsip',
        'tglberakhirstr',
        'tglterbitsip',
        'tglterbitstr',
        'kddokterbpjs',
        'isdpjp',
        'tgllahir',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'kodepos',
        'rt',
        'rw',
        'jabatan_id',
        'users_id',
        'jenispegawai_id',
        'golonganpegawai_id',
        'unitkerja_id',
        'kategorypegawai_id',
        'statuspegawai_id',
        'kelompokpegawai_id',
        'statuspegawai_id',
        'kelompokpegawai_id',
        'shiftkerja_id',
        'namabank',
        'norekening',
        'namarekening',
        'namakeluarga',
        'fingerprintid',
        'tgldaftarfingerprint',
        'tglmasuk',
        'tglkeluar',
        'ihs_id',
        'photo',
    ];

    protected $dates = [
        'tglberakhirsip',
        'tglberakhirstr',
        'tglterbitsip',
        'tglterbitstr',
        'tgllahir',
        'tgldaftarfingerprint',
        'tglmasuk',
        'tglkeluar',
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
        return $this->belongsTo(JenisKelamin::class, 'jeniskelamin_id');
    }

    public function golongandarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'golongandarah_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function statusperkawinan()
    {
        return $this->belongsTo(StatusPerkawinan::class, 'statusperkawinan_id');
    }

    public function warganegara()
    {
        return $this->belongsTo(Warganegara::class);
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

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function jenispegawai()
    {
        return $this->belongsTo(JenisPegawai::class, 'jenispegawai_id');
    }

    public function golonganpegawai()
    {
        return $this->belongsTo(GolonganPegawai::class, 'golonganpegawai_id');
    }

    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function kategorypegawai()
    {
        return $this->belongsTo(Kategorypegawai::class, 'kategorypegawai_id');
    }

    public function statuspegawai()
    {
        return $this->belongsTo(StatusPegawai::class, 'statuspegawai_id');
    }

    public function kelompokpegawai()
    {
        return $this->belongsTo(KelompokPegawai::class, 'kelompokpegawai_id');
    }

    public function shiftkerja()
    {
        return $this->belongsTo(ShiftKerja::class, 'shiftkerja_id');
    }
}
