<?php

use App\Http\Controllers\AdminCT;
use App\Http\Controllers\AuthCT;
use App\Http\Controllers\DasarTarifCT;
use App\Http\Controllers\ManajemenTarifCT;
use App\Http\Controllers\PetugasCT;
use App\Http\Controllers\Select2CT;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthCT::class, 'login']);
Route::post('/login/action', [AuthCT::class, 'loginAction']);

Route::get('logout', [AuthCT::class, 'logout']);

Route::group(['middleware' => 'AuthMD', 'prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminCT::class, 'dashboard'])->name('dashboard');


    Route::group(['prefix' => 'tarif'], function () {
        Route::group(['prefix' => 'dasar'], function () {
            Route::get('/', [DasarTarifCT::class, 'index'])->name('dasar-tarif');
            Route::post('tambah', [DasarTarifCT::class, 'tambah'])->name('dasar-tarif-tambah');
            Route::get('delete/{id_dasar_tarif}/{id_gerbang}', [DasarTarifCT::class, 'delete'])->name('dasar-tarif-delete');
            Route::get('edit/{id_dasar_tarif}/{id_gerbang}', [DasarTarifCT::class, 'edit'])->name('dasar-tarif-edit');
            Route::post('update', [DasarTarifCT::class, 'update'])->name('dasar-tarif-update');
        });
    });

    Route::group(['prefix' => 'manajemen-tarif'], function () {
        Route::group(['prefix' => 'open'], function () {
            Route::get('/', [ManajemenTarifCT::class, 'indexOpen']);
            Route::post('tambah', [ManajemenTarifCT::class, 'tambah']);
            Route::get('delete/{id_tarif}/{id_gerbang}', [ManajemenTarifCT::class, 'delete']);
            Route::get('edit/{id_tarif}/{id_gerbang}', [ManajemenTarifCT::class, 'edit']);
            Route::get('get-investor-by-id/{id}/{id_gerbang}', [ManajemenTarifCT::class, 'GetInvestor']);

            Route::post('update', [ManajemenTarifCT::class, 'update']);
        });
        Route::group(['prefix' => 'close'], function () {
            Route::get('/', [ManajemenTarifCT::class, 'indexclose']);
            Route::post('tambah', [ManajemenTarifCT::class, 'tambahExit']);
            Route::post('update', [ManajemenTarifCT::class, 'updateExit']);

            Route::get('export/{id_gerbang}', [ManajemenTarifCT::class, 'exportClose']);
            Route::get('view/{id_gerbang}', [ManajemenTarifCT::class, 'viewClose']);

            Route::get('delete/{id_tarif}/{id_gerbang}', [ManajemenTarifCT::class, 'delete']);
            Route::get('edit/{id_tarif}/{id_gerbang}', [ManajemenTarifCT::class, 'edit']);
            Route::get('get-investor-by-id/{id}/{id_gerbang}', [ManajemenTarifCT::class, 'GetInvestor']);
        });
    });



    Route::group(['prefix' => 'manajemen-tarif'], function () {
        Route::get('/', [ManajemenTarifCT::class, 'index']);
    });

    Route::group(['prefix' => 'petugas'], function () {
        Route::get('buat-petugas', [PetugasCT::class, 'BuatPetugas']);
        Route::post('buat-petugas/tambah', [PetugasCT::class, 'BuatPetugasTambah']);
        Route::get('buat-petugas/delete/{id}', [PetugasCT::class, 'BuatPetugasDelete']);
        Route::get('buat-petugas/edit/{id}', [PetugasCT::class, 'BuatPetugasEdit']);
        Route::post('buat-petugas/update/{id}', [PetugasCT::class, 'BuatPetugasUpdate']);
        Route::get('buat-petugas/sycron', [PetugasCT::class, 'BuatPetugasSycron']);
    });

    Route::get('get-gerbang-data', [Select2CT::class, 'getGerbang']);
    Route::get('get-gerbang-data-open', [Select2CT::class, 'getGerbangOpen']);
    Route::get('get-gerbang-data-exit', [Select2CT::class, 'getGerbangExit']);

    Route::post('get-dasar-tarif', [Select2CT::class, 'getDasarTarif']);

    Route::get('get-gerbang-ajax/{id}', [Select2CT::class, 'getGerbangAjax']);
});
