<?php

use App\Http\Controllers\PetugasCT;
use Illuminate\Support\Facades\Route;

Route::prefix('petugas')->group(function () {
  Route::controller(PetugasCT::class)->group(function () {

    // buat petugas route
    Route::get('/buat-petugas', 'BuatPetugas');
    Route::post('/buat-petugas/tambah', 'BuatPetugasTambah');
    Route::get('/buat-petugas/delete/{id}/{gerbang_conn}', 'BuatPetugasDelete');
    Route::get('/buat-petugas/edit/{id}/{gerbang_conn}', 'BuatPetugasEdit');
    Route::post('/buat-petugas/update/{id}', 'BuatPetugasUpdate');
    Route::get('/buat-petugas/sycron', 'BuatPetugasSycron');
    Route::post('/buat-petugas/import', 'importPetugas');

    // buat kartu ops
    Route::get("/buat-kartu-ops", 'BuatKartuOps');

    // data petugas
    Route::get("/data-petugas", 'DataPetugas');
  });
});