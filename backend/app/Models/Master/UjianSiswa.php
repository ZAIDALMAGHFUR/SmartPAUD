<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSiswa extends Model
{
    use HasFactory;

    protected $table = 'ujiansiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'ujian_id',
        'siswa_id',
        'started_at',
        'ended_at',
        'nilai',
        'user_agent',
        'ip_address',
        'status'
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
