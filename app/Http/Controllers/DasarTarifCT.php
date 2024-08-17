<?php

namespace App\Http\Controllers;

use App\Models\tbl_dasar_tarif;
use App\Models\tbl_gerbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class DasarTarifCT extends Controller
{
    //

    public function index(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');

        if($selectedGerbang && request()->ajax()){
            $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            return DataTables::of(tbl_dasar_tarif::query())
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
                // 'BtnInfo' => [
                //     'url' => '/admin/document/create',
                //     'name' => "Add Dasar Tarif"
                // ],
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
        $gerbang = tbl_gerbang::where('gerbang_id', $request->gerbangmodal)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = new tbl_dasar_tarif;
        $model->versi_tarif = $request->versi;
        $model->dasar_tarif = $request->sk;
        $model->mulai_berlaku = $request->waktu;
        $model->save();
        return true;
    }

    public function delete($id_dasar_tarif, $id_gerbang)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = tbl_dasar_tarif::where('id_dasar_tarif', $id_dasar_tarif)->first();
        $model->delete();
        return true;
    }

    public function edit($id_dasar_tarif, $id_gerbang)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = tbl_dasar_tarif::where('id_dasar_tarif', $id_dasar_tarif)->first();

        return response()->json(compact('model'));
    }

    public function update(Request $request)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $request->gerbangmodal)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = tbl_dasar_tarif::where('id_dasar_tarif', $request->id)->first();
        $model->versi_tarif = $request->versi;
        $model->dasar_tarif = $request->sk;
        $model->mulai_berlaku = $request->waktu;
        $model->save();
        return true;
    }
}
