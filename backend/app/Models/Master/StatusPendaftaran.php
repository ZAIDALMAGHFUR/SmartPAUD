<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'statuspendaftaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
