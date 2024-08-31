<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahunajaran';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
