<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasSiswa extends Model
{
    use HasFactory;

    protected $table = 'tugassiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
        'type',
        'file_or_link',
        'kelas_id',
        'tahunajaran_id',
        'guru_id',
        'matapelajaran_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }

    public function pertanyaan()
    {
        return $this->hasMany(TugasSiswaDetail::class, 'tugassiswa_id');
    }
}
