<?php

use App\Http\Controllers\KartuCT;
use Illuminate\Support\Facades\Route;

Route::prefix('kartu')->group(function () {
  Route::controller(KartuCT::class)->group(function() {
    // penerbitan routes
    Route::get('/penerbitan', 'index');
    Route::post('/penerbitan/tambah', 'tambah_kartu');
    Route::post('/penerbitan/blacklist/{id}', 'blacklist_ktp');
    Route::post('/penerbitan/whitelist/{id}', 'whitelist_ktp');

    // buat kartu routes
    Route::get('/buat', 'buat');
    Route::post('/buat/getDetailData', 'getDetailData');
    Route::post('/buat/generateDataKartu', 'generateDataKartu');
    Route::post('/buat/updateUID', 'updateUID');
    Route::post('/buat/getDetailKTP', 'getDetailKTP');
    
    // Route::post('/simpan', 'simpan');

    // baca kartu routes
    Route::get('/baca', 'baca');

    // perpanjang kartu routes
    Route::get('/perpanjang', 'perpanjang');

    // blacklist kartu routes
    Route::get('/blacklist', 'blacklist');
  });
});

