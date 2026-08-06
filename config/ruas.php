<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ruas Tol Aktif
    |--------------------------------------------------------------------------
    |
    | Aplikasi ini di-deploy per ruas jalan tol. Nilai di bawah menentukan
    | ruas mana yang datanya akan diambil/ditampilkan pada instance ini.
    | Saat deploy ke ruas lain, cukup ubah RUAS_ID & RUAS_NAME di file .env.
    |
    */

    'id' => env('RUAS_ID', 'b001'),

    'name' => env('RUAS_NAME', 'JMJ'),
];
