<?php

use App\Http\Controllers\DasarTarifCT;
use Illuminate\Support\Facades\Route;

Route::prefix('tarif/dasar')->group(function () {
  Route::controller(DasarTarifCT::class)->group(function () {
    Route::get('/', 'index')->name('dasar-tarif');
    Route::post('/tambah', 'tambah')->name('dasar-tarif-tambah');
    Route::get('/delete/{id_dasar_tarif}/{id_gerbang}', 'delete')->name('dasar-tarif-delete');
    Route::get('/edit/{id_dasar_tarif}/{id_gerbang}', 'edit')->name('dasar-tarif-edit');
    Route::post('/update', 'update')->name('dasar-tarif-update');
  });
});