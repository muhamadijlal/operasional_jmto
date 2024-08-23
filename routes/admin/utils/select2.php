<?php

use App\Http\Controllers\Select2CT;
use Illuminate\Support\Facades\Route;

Route::controller(Select2CT::class)->group(function () {
  Route::get('get-gerbang-data', 'getGerbang');
  Route::get('get-jabatan-data', 'getJabatan');
  Route::get('get-nama-kspt', 'getNamaKspt');
  Route::post('get-nama-personil', 'getNamaPersonil');
  Route::get('get-gerbang-data-open', 'getGerbangOpen');
  Route::get('get-gerbang-data-exit', 'getGerbangExit');
  Route::post('get-dasar-tarif', 'getDasarTarif');
  Route::get('get-gerbang-ajax/{id}', 'getGerbangAjax');
});