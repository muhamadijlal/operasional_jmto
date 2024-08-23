<?php

use App\Http\Controllers\AuthCT;
use Illuminate\Support\Facades\Route;

Route::controller(AuthCT::class)->group(function () {
  Route::get('/', 'login');
  Route::post('/login/action','loginAction');
  Route::get('/logout', 'logout');
});