<?php

use App\Http\Controllers\Select2CT;
use Illuminate\Support\Facades\Route;

Route::controller(Select2CT::class)->group(function () {
  Route::get('get-gerbang-data', 'getGerbang');
  Route::get('get-ruas-kartu', 'getRuasKartu');
  Route::get('get-ruas', 'getRuas');
  Route::get('get-institusi', 'getInstitusi');
  Route::get('get-unit', 'getUnit');
  Route::get('get-option-nama', 'getOptionNama');
  Route::get('get-jabatan-data', 'getJabatan');
  Route::get('get-nama-kspt', 'getNamaKspt');
  Route::get('get-ktp-opr', 'getKtpOpr');
  Route::post('get-nama-personil', 'getNamaPersonil');
  Route::get('get-gerbang-data-open', 'getGerbangOpen');
  Route::get('get-gerbang-data-exit', 'getGerbangExit');
  Route::post('get-dasar-tarif', 'getDasarTarif');
  Route::get('get-gerbang-ajax/{id}', 'getGerbangAjax');
});