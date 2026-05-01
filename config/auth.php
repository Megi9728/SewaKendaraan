<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    | Default guard adalah 'customer' karena mayoritas pengguna adalah customer.
    | Admin dan Mitra menggunakan guard terpisah.
    */

    'defaults' => [
        'guard'     => 'customer',
        'passwords' => 'customers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | 3 guard terpisah sesuai ERD:
    | - admin    → tabel admins
    | - mitra    → tabel mitras
    | - customer → tabel customers
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],

        'customer' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],

        'mitra' => [
            'driver'   => 'session',
            'provider' => 'mitras',
        ],

        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Customer::class,
        ],

        'mitras' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Mitra::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'mitras' => [
            'provider' => 'mitras',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
