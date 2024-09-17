<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    use HasFactory;

    protected $table = 'absensiguru';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'status',
        'rangkuman',
        'beritaacara',
        'kelassiswa_id',
        'guru_id',
        'matapelajaran_id',
        'kelas_id',
        'tahunajaran_id',
    ];

    public function KelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'siswatransaksi_id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function matapelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id');
    }
}
