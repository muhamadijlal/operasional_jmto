<?php

use App\Http\Controllers\LogCT;
use Illuminate\Support\Facades\Route;


Route::prefix('logs')->group(function () {
  Route::controller(LogCT::class)->group(function () {
    Route::get('/', 'getLog');
  });
});