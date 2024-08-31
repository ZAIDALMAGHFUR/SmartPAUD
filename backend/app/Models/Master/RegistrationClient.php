<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationClient extends Model
{
    use HasFactory;

    protected $table = 'registrations_client';

    protected $fillable = [
        'name',
        'id_register',
        'client_key',
        'server_key',
        'secret_key',
        'expired_at',
    ];
}
