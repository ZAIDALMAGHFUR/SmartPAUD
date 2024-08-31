<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WargaNegara extends Model
{
    use HasFactory;

    protected $table = 'warganegara';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
    ];
}
