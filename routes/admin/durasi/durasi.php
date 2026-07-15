<?php

use App\Http\Controllers\DurasiCT;
use Illuminate\Support\Facades\Route;

Route::prefix('durasi')->group(function () {
  Route::controller(DurasiCT::class)->group(function () {
    Route::get('/', 'index')->name('durasi');
    Route::get('/asal-gerbang/{id_gerbang}', 'getAsalGerbang')->name('durasi-asal-gerbang');
    Route::post('/tambah', 'tambah')->name('durasi-tambah');
    Route::get('/edit/{asal_gerbang}/{id_gerbang}', 'edit')->name('durasi-edit');
    Route::post('/update', 'update')->name('durasi-update');
    Route::get('/delete/{asal_gerbang}/{id_gerbang}', 'delete')->name('durasi-delete');
  });
});
