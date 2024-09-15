<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalUjianEssay extends Model
{
    use HasFactory;

    protected $table = 'soalujianessay';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'nomor_soal',
        'pertanyaan',
        'ujian_id',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
