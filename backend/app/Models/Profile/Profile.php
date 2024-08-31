<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = [
        'kdprofile',
        'statusenabled',
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'website',
        'slogan',
        'description',
        'vision',
        'mission',
        'motto',
        'fax',
        'npwp',
        'npsn'
    ];
}
