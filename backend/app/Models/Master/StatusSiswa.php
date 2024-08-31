<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSiswa extends Model
{
    use HasFactory;

    protected $table = 'statussiswa';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
