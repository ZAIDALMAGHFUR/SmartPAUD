<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganPegawai extends Model
{
    use HasFactory;

    protected $table = 'golonganpegawai';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
