<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokPegawai extends Model
{
    use HasFactory;

    protected $table = 'kelompokpegawai';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
