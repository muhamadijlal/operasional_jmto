<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['AuthMD'])->group(function () {
  Route::prefix('admin')->group(function () {
    require 'dashboard/dashboard.php';
    require 'durasi/durasi.php';
    require 'logs/log.php';
    require 'tarif/tarif.php';
    require 'tarif/manajemen-tarif.php';
    require 'petugas/petugas.php';
    require 'kartu/kartu.php';
    require 'utils/select2.php';
  });
});