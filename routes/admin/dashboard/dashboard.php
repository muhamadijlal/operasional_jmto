<?php

use App\Http\Controllers\AdminCT;
use Illuminate\Support\Facades\Route;

Route::controller(AdminCT::class)->group(function () {
  Route::get('dashboard', 'dashboard')->name('dashboard');
});