<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    use HasFactory;

    protected $table = 'statusbarang';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name'
    ];
}
