<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Pastikan ini diimpor
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable // Pastikan ini mengimplementasikan Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin'; // Pastikan guard ini diset ke 'admin'

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Pastikan ini ada untuk meng-hash password secara otomatis saat diisi
    ];
}