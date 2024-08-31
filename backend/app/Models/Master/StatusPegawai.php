<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    use HasFactory;

    protected $table = 'statuspegawai';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
