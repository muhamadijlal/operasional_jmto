<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManajemenTarifCT;

Route::prefix('manajemen-tarif')->group(function () {
  Route::controller(ManajemenTarifCT::class)->group(function () {
    Route::get('/', 'index');

    Route::prefix('open')->group(function () {
      Route::get('/', 'indexOpen');
      Route::post('tambah', 'tambah');
      Route::get('delete/{id_tarif}/{id_gerbang}', 'delete');
      Route::get('edit/{id_tarif}/{id_gerbang}', 'edit');
      Route::get('get-investor-by-id/{id}/{id_gerbang}', 'GetInvestor');
      Route::post('update', 'update');
    });

    Route::prefix('close')->group(function () {
      Route::get('/', 'indexclose');
      Route::get('import', 'importclose');
      Route::post('import', 'importcloseStore');
      Route::post('tambah', 'tambahExit');
      Route::post('update', 'updateExit');
      Route::get('export/{id_gerbang}', 'exportClose');
      Route::get('view/{id_gerbang}', 'viewClose');
      Route::get('delete/{id_tarif}/{id_gerbang}', 'delete');
      Route::get('edit/{id_tarif}/{id_gerbang}', 'edit');
      Route::get('get-investor-by-id/{id}/{id_gerbang}', 'GetInvestor');
    });
  });
});