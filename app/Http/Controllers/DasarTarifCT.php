<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DasarTarifCT extends Controller
{
    public function index(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');

        if($selectedGerbang && request()->ajax()){
            $gerbang = DB::connection('mysql')->table("tbl_gerbang")->where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            $query = DB::connection('mysql2')->table('tbl_dasar_tarif');

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = '
                            <a href="#" class="btn m-1 btn-warning btn-sm btnEditDasarTarif" id="btnEditDasarTarif" data-url="' . $row->id_dasar_tarif . '" > <i class="fa fa-edit" ></i> Edit</a>
                            <a href="#" class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id_dasar_tarif . '"> <i class="fa fa-trash"></i> Delete</a>
                        ';

                    return $btn;
                })
                ->make();
        }

        return view(
            'admin.dasar-tarif.list',
            [
                'judul' => 'Dasar Tarif',
                'Cloums' => [
                    [

                        'title' => 'Versi Tarif',
                        'data' => 'versi_tarif',
                        'name' => 'tbl_dasar_tarif.versi_tarif',
                    ],
                    [

                        'title' => 'Dasar Tarif',
                        'data' => 'dasar_tarif',
                        'name' => 'tbl_dasar_tarif.dasar_tarif',
                    ],
                    [

                        'title' => 'Mulai Berlaku',
                        'data' => 'mulai_berlaku',
                        'name' => 'tbl_dasar_tarif.mulai_berlaku',
                    ],

                    [
                        'data' => 'action',
                        'name' => 'action',
                    ],
                ]
            ]
        );
    }


    public function tambah(Request $request)
    {
        $gerbang = DB::connection('mysql')->table("tbl_gerbang")->where('gerbang_id', $request->gerbangmodal)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        DB::connection('mysql2')->table("tbl_dasar_tarif")->insert([
            'versi_tarif' => $request->versi,
            'dasar_tarif' => $request->sk,
            'mulai_berlaku' => $request->waktu,
        ]);

        return true;
    }

    public function delete($id_dasar_tarif, $id_gerbang)
    {
        $gerbang = DB::connection('mysql')->table("tbl_gerbang")->where('gerbang_id', $id_gerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        DB::connection('mysql2')->table('tbl_dasar_tarif')->where('id_dasar_tarif', $id_dasar_tarif)->delete();

        return true;
    }

    public function edit($id_dasar_tarif, $id_gerbang)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $id_gerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = DB::connection('mysql2')->table('tbl_dasar_tarif')->where('id_dasar_tarif', $id_dasar_tarif)->first();

        return response()->json(compact('model'));
    }

    public function update(Request $request)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $request->gerbangmodal)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        DB::connection('mysql2')->table("tbl_dasar_tarif")->where('id_dasar_tarif', $request->id)->update([
            'versi_tarif' => $request->versi,
            'dasar_tarif' => $request->sk,
            'mulai_berlaku' => $request->waktu,
        ]);

        return true;
    }
}
