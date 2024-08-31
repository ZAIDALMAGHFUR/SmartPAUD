<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'unitkerja';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
