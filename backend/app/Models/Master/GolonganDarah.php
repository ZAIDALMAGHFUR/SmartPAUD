<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganDarah extends Model
{
    use HasFactory;

    protected $table = 'golongandarah';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
