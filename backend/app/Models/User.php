<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // protected $table = 'users';


    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'roles_id',
        'is_active',
        'is_verified',
        'verification_token',
        'reset_token',
        'reset_token_expires_at',
        'last_login_at',
        'last_failed_login_at',
        'failed_login_count',
        'last_failed_login_ip',
        'last_login_ip',
        'timezone',
        'locale',
        'ip_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'users', 'id', 'roles_id');
    }
}
