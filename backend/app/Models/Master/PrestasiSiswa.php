<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'prestasisiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'siswa_id',
        'jenisprestasi',
        'namaprestasi',
        'tingkatprestasi',
        'peringkat',
        'penyelenggara',
        'tanggalprestasi',
        'dokumenprestasi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
