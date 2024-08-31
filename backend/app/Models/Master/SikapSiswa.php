<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SikapSiswa extends Model
{
    use HasFactory;

    protected $table = 'sikapsiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
