<?php

namespace App\Http\Controllers;

use App\Models\tbl_dasar_tarif;
use App\Models\tbl_gerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Select2CT extends Controller
{
    //

    public function getGerbang(Request $request)
    {
        // if ($request->has('q')) {
        $cari = $request->q;
        $data = tbl_gerbang::whereRaw("(gerbang_nama LIKE '%" . $request->get('q') . "%')")
            ->orderBy('gerbang_nama', 'asc')
            ->get();
        return response()->json($data);

        // $data = tbl_gerbang::all();
        // return response()->json($data);
        // }
    }

    public function getGerbangOpen(Request $request)
    {

        $cari = $request->q;
        $data = tbl_gerbang::whereRaw("(gerbang_nama LIKE '%" . $request->get('q') . "%') AND status = '1' AND (jenis_gerbang='0'OR jenis_gerbang='1'OR jenis_gerbang='2' OR jenis_gerbang='4' )")
            ->orderBy('gerbang_nama', 'asc')
            ->get();
        return response()->json($data);
    }

    public function getGerbangExit(Request $request)
    {

        $cari = $request->q;
        $data = tbl_gerbang::whereRaw("(gerbang_nama LIKE '%" . $request->get('q') . "%') AND status = '1' AND (jenis_gerbang='1' OR jenis_gerbang='3' OR jenis_gerbang='4' )")
            ->orderBy('gerbang_nama', 'asc')
            ->get();
        return response()->json($data);
    }



    public function getDasarTarif(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $data = tbl_dasar_tarif::get();
        return response()->json($data);
    }

    public function getGerbangAjax($id)
    {

        $data = tbl_gerbang::where('gerbang_id', '!=', $id)->get();
        return response()->json($data);
    }
}
