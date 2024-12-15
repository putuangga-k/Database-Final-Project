<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Semua atribut yang dapat diisi secara mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
        'admin_name',
        'phone',
        'address',
    ];

    // Atribut yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
