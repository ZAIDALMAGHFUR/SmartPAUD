<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiawayatKesehatanSiswa extends Model
{
    use HasFactory;

    protected $table = 'riawayatkesehatansiswas';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'siswa_id',
        'penyakit',
        'riwayatpengobatan',
        'alergi',
        'catatankesehatanlainnya',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
