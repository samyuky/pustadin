<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    // HANYA ADA SATU BLOK 'guards' INI
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [ // Pastikan guard ini ada
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admins' => [ // Pastikan provider ini ada dan menunjuk ke model Admin Anda
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        // Jika Anda ingin reset password untuk admin, tambahkan juga di sini:
        // 'admins' => [
        //     'provider' => 'admins',
        //     'table' => 'password_reset_tokens', // Atau tabel khusus admin
        //     'expire' => 60,
        //     'throttle' => 60,
        // ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];