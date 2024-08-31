<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorypegawai extends Model
{
    use HasFactory;

    protected $table = 'kategorypegawai';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
