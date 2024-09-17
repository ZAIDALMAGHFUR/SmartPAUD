<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportSiswa extends Model
{
    use HasFactory;

    protected $table = 'raportsiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'kelassiswa_id',
        'kelas_id',
        'tahunajaran_id',
        'guru_id',
        'matapelajaran_id',
        'jumlahkdpengetahuan',
        'nilaipengetahuan',
        'predikatpengetahuan',
        'jumlahkdketerampilan',
        'nilaiketerampilan',
        'predikatketerampilan',
        'ratarata',
        'catatanwalikelas',
        'tanggapanorangtua'
    ];

    public function kelassiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function matapelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
