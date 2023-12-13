<?php

namespace App\Http\Controllers;

use App\Models\tbl_dasar_tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminCT extends Controller
{

    public function dashboard()
    {
        // // Mengatur konfigurasi koneksi database secara dinamis
        // Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        // Config::set('database.connections.mysql2.host', '127.0.0.1');
        // Config::set('database.connections.mysql2.port', '3306');
        // Config::set('database.connections.mysql2.database', 'jago_lattol_02');
        // Config::set('database.connections.mysql2.username', 'root');
        // Config::set('database.connections.mysql2.password', '');


        // dd(tbl_dasar_tarif::all());

        return view('admin.dashboard');
    }
}
