<?php

namespace App\Http\Controllers;

use App\Models\tbl_gerbang;
use App\Models\tbl_tarif_exit;
use App\Models\tbl_tarif_open;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ManajemenTarifCT extends Controller
{
    //

    public function index(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {
            $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);



            if ($gerbang->jenis_gerbang == 0) {
                $model = tbl_tarif_open::query();
                $model->join('tbl_gerbang', 'tbl_gerbang.gerbang_id', '=', 'tbl_tarif_open.gerbang_id');
                $model->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_open.id_dasar_tarif');
                $selectOpen = [
                    'tbl_tarif_open.id',
                    'tbl_gerbang.gerbang_nama',
                    'tbl_dasar_tarif.dasar_tarif',
                    'tbl_tarif_open.gol1',
                    'tbl_tarif_open.gol2',
                    'tbl_tarif_open.gol3',
                    'tbl_tarif_open.gol4',
                    'tbl_tarif_open.gol5',
                    'tbl_tarif_open.tgl_berlaku',
                ];
                $model->select($selectOpen);
            } else {

                $model = tbl_tarif_exit::query();
                $model->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'tbl_tarif_exit.gerbang_id')
                    ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'tbl_tarif_exit.asal_gerbang')
                    ->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_exit.id_dasar_tarif');

                $model->select([
                    'tbl_tarif_exit.id',
                    'gerbang.gerbang_nama as gerbang1',
                    'gerbang_asal.gerbang_nama',
                    'tbl_tarif_exit.jenis',
                    'tbl_dasar_tarif.dasar_tarif',
                    'tbl_tarif_exit.gol1',
                    'tbl_tarif_exit.gol2',
                    'tbl_tarif_exit.gol3',
                    'tbl_tarif_exit.gol4',
                    'tbl_tarif_exit.gol5',
                    'tbl_tarif_exit.tgl_berlaku',
                ]);
            }

            return DataTables::of($model)
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button class="btn m-1 btn-warning btn-sm btnEditTarif" id="btnEditTarif" data-url="' . $row->id . '" > <i class="fa fa-edit" ></i> Edit</button>
                        <button class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id . '"> <i class="fa fa-trash"></i> Delete</button>
                        <button class="btn m-1 btn-info btn-sm" id="btnDetailInvestor" data-url="' . $row->id . '"> <i class="fa fa-eye"></i> Investor</button>
                    ';

                    return $btn;
                })
                // ->addColumn('nama_gerbang', function ($row) {
                //     $btn = '
                //         <a href="#" class="btn m-1 btn-warning btn-sm btnDetailTarif" id="btnDetailTarif" data-url="' . $row->id . '" > <i class="fa fa-eye" ></i> ' . $row->nama_gerbang . '</a>
                //     ';

                //     return $btn;
                // })
                ->make();
        }
        return view(
            'list.manajemen_tarif',
            [
                'judul' => 'Manajemen Tarif',
                // 'BtnInfo' => [
                //     'url' => '/admin/document/create',
                //     'name' => "Add Dasar Tarif"
                // ],
                'Cloums' => []
            ]
        );
    }

    public function indexOpen(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {
            $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            $model = tbl_tarif_open::query();
            $model->join('tbl_gerbang', 'tbl_gerbang.gerbang_id', '=', 'tbl_tarif_open.gerbang_id');
            $model->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_open.id_dasar_tarif');
            $selectOpen = [
                'tbl_tarif_open.id',
                'tbl_gerbang.gerbang_nama',
                'tbl_dasar_tarif.dasar_tarif',
                'tbl_tarif_open.gol1',
                'tbl_tarif_open.gol2',
                'tbl_tarif_open.gol3',
                'tbl_tarif_open.gol4',
                'tbl_tarif_open.gol5',
                'tbl_tarif_open.tgl_berlaku',
            ];
            $model->select($selectOpen);


            return DataTables::of($model)
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button class="btn m-1 btn-warning btn-sm btnEditTarif" id="btnEditTarif" data-url="' . $row->id . '" > <i class="fa fa-edit" ></i> Edit</button>
                        <button class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id . '"> <i class="fa fa-trash"></i> Delete</button>
                        <button class="btn m-1 btn-info btn-sm" id="btnDetailInvestor" data-url="' . $row->id . '"> <i class="fa fa-eye"></i> Investor</button>
                    ';

                    return $btn;
                })->make();
        }
        return view(
            'list.manajemen_tarif_open',
            [
                'judul' => 'Manajemen Tarif Open',
                'Cloums' => [
                    [

                        'title' => 'Nama Gerbang',
                        'data' => 'gerbang_nama',
                        'name' => 'tbl_gerbang.gerbang_nama',
                    ],
                    [

                        'title' => 'Dasar Tarif',
                        'data' => 'dasar_tarif',
                        'name' => 'tbl_dasar_tarif.dasar_tarif',
                    ],
                    [

                        'title' => 'Golongan 1',
                        'data' => 'gol1',
                        'name' => 'tbl_tarif_open.gol1',
                    ],
                    [

                        'title' => 'Golongan 2',
                        'data' => 'gol2',
                        'name' => 'tbl_tarif_open.gol2',
                    ],
                    [

                        'title' => 'Golongan 3',
                        'data' => 'gol3',
                        'name' => 'tbl_tarif_open.gol3',
                    ],
                    [

                        'title' => 'Golongan 4',
                        'data' => 'gol4',
                        'name' => 'tbl_tarif_open.gol4',
                    ],
                    [

                        'title' => 'Golongan 5',
                        'data' => 'gol5',
                        'name' => 'tbl_tarif_open.gol5',
                    ],
                    [

                        'title' => 'Waktu Berlaku',
                        'data' => 'tgl_berlaku',
                        'name' => 'tbl_tarif_open.tgl_berlaku',
                    ],

                    [
                        'title' => 'Action',
                        'data' => 'action',
                        'name' => 'action',
                    ],
                ]
            ]
        );
    }


    public function indexclose(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {
            $gerbang = tbl_gerbang::where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            $model = tbl_tarif_exit::query();
            $model->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'tbl_tarif_exit.gerbang_id')
                ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'tbl_tarif_exit.asal_gerbang')
                ->leftjoin('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_exit.id_dasar_tarif');

            $model->select([
                'tbl_tarif_exit.id',
                'gerbang.gerbang_nama as gerbang1',
                'gerbang_asal.gerbang_nama as asalGerbang',
                'tbl_tarif_exit.jenis',
                'tbl_dasar_tarif.dasar_tarif',
                'tbl_tarif_exit.gol1',
                'tbl_tarif_exit.gol2',
                'tbl_tarif_exit.gol3',
                'tbl_tarif_exit.gol4',
                'tbl_tarif_exit.gol5',
                'tbl_tarif_exit.tgl_berlaku',
            ]);


            return DataTables::of($model)
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button class="btn m-1 btn-warning btn-sm btnEditTarif" id="btnEditTarif" data-url="' . $row->id . '" > <i class="fa fa-edit" ></i> Edit</button>
                        <button class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id . '"> <i class="fa fa-trash"></i> Delete</button>
                        <button class="btn m-1 btn-info btn-sm" id="btnDetailInvestor" data-url="' . $row->id . '"> <i class="fa fa-eye"></i> Investor</button>
                    ';

                    return $btn;
                })->make();
        }
        return view(
            'list.manajemen_tarif_exit',
            [
                'judul' => 'Manajemen Tarif Exit',
                'Cloums' => [
                    [

                        'title' => 'Nama Gerbang',
                        'data' => 'gerbang1',
                        'name' => 'gerbang.gerbang_nama',
                    ],
                    [

                        'title' => 'asal Gerbang',
                        'data' => 'asalGerbang',
                        'name' => 'gerbang_asal.gerbang_nama',
                    ],
                    [

                        'title' => 'Dasar Tarif',
                        'data' => 'dasar_tarif',
                        'name' => 'tbl_dasar_tarif.dasar_tarif',
                    ],
                    [

                        'title' => 'Golongan 1',
                        'data' => 'gol1',
                        'name' => 'tbl_tarif_open.gol1',
                    ],
                    [

                        'title' => 'Golongan 2',
                        'data' => 'gol2',
                        'name' => 'tbl_tarif_open.gol2',
                    ],
                    [

                        'title' => 'Golongan 3',
                        'data' => 'gol3',
                        'name' => 'tbl_tarif_open.gol3',
                    ],
                    [

                        'title' => 'Golongan 4',
                        'data' => 'gol4',
                        'name' => 'tbl_tarif_open.gol4',
                    ],
                    [

                        'title' => 'Golongan 5',
                        'data' => 'gol5',
                        'name' => 'tbl_tarif_open.gol5',
                    ],
                    [

                        'title' => 'Waktu Berlaku',
                        'data' => 'tgl_berlaku',
                        'name' => 'tbl_tarif_open.tgl_berlaku',
                    ],

                    [
                        'title' => 'Action',
                        'data' => 'action',
                        'name' => 'action',
                    ],
                ]
            ]
        );
    }

    public function array_string($array)
    {
        $data = '[';
        foreach ($array as $key => $value) {
            $data .= $value . ',';
        }

        // Menghapus koma terakhir
        $data = rtrim($data, ',');

        $data .= ']';

        return $data;
    }

    public function array_string2($array)
    {
        $data = '["';
        foreach ($array as $key => $value) {
            $data .= $value . '","';
        }

        // Menghapus koma terakhir
        $data = rtrim($data, ',"');

        $data .= '"]';

        return $data;
    }

    public function tambah(Request $request)
    {

        try {
            $gerbang = tbl_gerbang::where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error Database']);
        }


        if ($gerbang->jenis_gerbang == 1 || $gerbang->jenis_gerbang == 2 || $gerbang->jenis_gerbang == 3) {


            try {
                if ($request->id != 0) {
                    $model =  tbl_tarif_exit::where('id', $request->id)->first();
                    $model->ruas_id = $gerbang->ruas_id;
                    $model->gerbang_id = $request->gerbangmodal;
                    $model->asal_gerbang = $request->asal_gerbang_update;
                    $model->jenis = $request->jenis;
                    $model->gol1 = $request->totalgol1;
                    $model->gol1_d =  $this->array_string($request->totalinvestor1);
                    $model->gol2 = $request->totalgol2;
                    $model->gol2_d = $this->array_string($request->totalinvestor2);
                    $model->gol3 = $request->totalgol3;
                    $model->gol3_d = $this->array_string($request->totalinvestor3);
                    $model->gol4 = $request->totalgol4;
                    $model->gol4_d = $this->array_string($request->totalinvestor4);
                    $model->gol5 = $request->totalgol5;
                    $model->gol5_d = $this->array_string($request->totalinvestor5);
                    $model->tgl_berlaku = $request->waktu;
                    $model->id_dasar_tarif = $request->dasartarifmodal;
                    $model->aktif = 1;
                    $model->tarif_inv = $this->array_string2($request->investor1);
                    // $model->bagi_hasil = $this->array_string2($request->investor1);
                    $model->save();
                } else {

                    $model = new tbl_tarif_exit;
                    $model->ruas_id = $gerbang->ruas_id;
                    $model->gerbang_id = $request->gerbangmodal;
                    $model->asal_gerbang = $request->asal_gerbang;
                    $model->jenis = $request->jenis;
                    $model->gol1 = $request->totalgol1;
                    $model->gol1_d =  $this->array_string($request->totalinvestor1);
                    $model->gol2 = $request->totalgol2;
                    $model->gol2_d = $this->array_string($request->totalinvestor2);
                    $model->gol3 = $request->totalgol3;
                    $model->gol3_d = $this->array_string($request->totalinvestor3);
                    $model->gol4 = $request->totalgol4;
                    $model->gol4_d = $this->array_string($request->totalinvestor4);
                    $model->gol5 = $request->totalgol5;
                    $model->gol5_d = $this->array_string($request->totalinvestor5);
                    $model->tgl_berlaku = $request->waktu;
                    $model->id_dasar_tarif = $request->dasartarifmodal;
                    $model->aktif = 1;
                    $model->tarif_inv = $this->array_string2($request->investor1);
                    // $model->bagi_hasil = $this->array_string2($request->investor1);
                    $model->save();
                }
                return true;
            } catch (\Throwable $th) {
                dd($th);
                // return response()->json(['message' => 'Error Add Data']);
            }
        } else {

            // try {

            //     if ($request->id != 0) {
            //         $model = tbl_tarif_open::where('id', $request->id)->first();
            //         $model->ruas = $gerbang->ruas_id;
            //         $model->gerbang_id = $request->gerbangmodal;
            //         $model->gol1 = $request->totalgol1;
            //         $model->gol1_d =  $this->array_string($request->totalinvestor1);
            //         $model->gol2 = $request->totalgol2;
            //         $model->gol2_d = $this->array_string($request->totalinvestor2);
            //         $model->gol3 = $request->totalgol3;
            //         $model->gol3_d = $this->array_string($request->totalinvestor3);
            //         $model->gol4 = $request->totalgol4;
            //         $model->gol4_d = $this->array_string($request->totalinvestor4);
            //         $model->gol5 = $request->totalgol5;
            //         $model->gol5_d = $this->array_string($request->totalinvestor5);
            //         $model->tgl_berlaku = $request->waktu;
            //         $model->id_dasar_tarif = $request->dasartarifmodal;
            //         $model->aktif = 1;
            //         $model->tarif_inv = $this->array_string2($request->investor1);
            //         $model->bagi_hasil = $this->array_string2($request->investor1);
            //         $model->save();
            //     } else {
            //         $model = new tbl_tarif_open;
            //         $model->ruas = $gerbang->ruas_id;
            //         $model->gerbang_id = $request->gerbangmodal;
            //         $model->gol1 = $request->totalgol1;
            //         $model->gol1_d =  $this->array_string($request->totalinvestor1);
            //         $model->gol2 = $request->totalgol2;
            //         $model->gol2_d = $this->array_string($request->totalinvestor2);
            //         $model->gol3 = $request->totalgol3;
            //         $model->gol3_d = $this->array_string($request->totalinvestor3);
            //         $model->gol4 = $request->totalgol4;
            //         $model->gol4_d = $this->array_string($request->totalinvestor4);
            //         $model->gol5 = $request->totalgol5;
            //         $model->gol5_d = $this->array_string($request->totalinvestor5);
            //         $model->tgl_berlaku = $request->waktu;
            //         $model->id_dasar_tarif = $request->dasartarifmodal;
            //         $model->aktif = 1;
            //         $model->tarif_inv = $this->array_string2($request->investor1);
            //         $model->bagi_hasil = $this->array_string2($request->investor1);
            //         $model->save();
            //     }

            //     return true;
            // } catch (\Throwable $th) {
            //     return response()->json(['message' => 'Error Add Data']);
            // }
        }
    }


    public function tambahExit(Request $request)
    {



        try {
            $gerbang = tbl_gerbang::where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);
        } catch (\Throwable $th) {
            return response()->json(['code' => 400, 'message' => 'Error Database']);
        }

        $model = new tbl_tarif_exit;
        $model->ruas_id = $gerbang->ruas_id;
        $model->gerbang_id = $request->gerbangmodal;
        $model->asal_gerbang = $request->asal_gerbang;
        $model->jenis = $request->jenis;
        $model->gol1 = $request->totalgol1;
        $model->gol1_d =  $request->totalInvestorValues1;
        $model->gol2 = $request->totalgol2;
        $model->gol2_d =  $request->totalInvestorValues2;
        $model->gol3 = $request->totalgol3;
        $model->gol3_d =  $request->totalInvestorValues3;
        $model->gol4 = $request->totalgol4;
        $model->gol4_d =  $request->totalInvestorValues4;
        $model->gol5 = $request->totalgol5;
        $model->gol5_d =  $request->totalInvestorValues5;

        $model->tgl_berlaku = $request->waktu;
        $model->id_dasar_tarif = $request->dasartarifmodal;
        $model->aktif = 1;
        $model->tarif_inv = str_replace('"', '', $request->investor1);
        // $model->bagi_hasil = $this->array_string2($request->investor1);
        $model->save();

        return response()->json(['code' => 200, 'message' => 'Success Add Data']);
    }

    public function delete($id_tarif, $id_gerbang)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);


        if ($gerbang->jenis_gerbang == 0) {
            $model = tbl_tarif_open::where('id', $id_tarif)->first();
            $model->delete();
        } else {
            $model = tbl_tarif_exit::where('id', $id_tarif)->first();
            $model->delete();
        }


        return true;
    }

    public function edit($id, $id_gerbang)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);


        if ($gerbang->jenis_gerbang == 0) {
            $model = tbl_tarif_open::where('id', $id)->first();
        } else {
            $model = tbl_tarif_exit::where('id', $id)->first();
        }

        // dd($model->tarif_inv);
        // dd($model->tarif_inv);

        return response()->json(compact('model'));
    }

    public function updateExit(Request $request)
    {
        try {
            $gerbang = tbl_gerbang::where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);
        } catch (\Throwable $th) {
            return response()->json(['code' => 400, 'message' => 'Error Database']);
        }

        $model =  tbl_tarif_exit::find($request->id);
        $model->ruas_id = $gerbang->ruas_id;
        $model->gerbang_id = $request->gerbangmodal;
        $model->asal_gerbang = $request->asal_gerbang;
        $model->jenis = $request->jenis;
        $model->gol1 = $request->totalgol1;
        $model->gol1_d =  $request->totalInvestorValues1;
        $model->gol2 = $request->totalgol2;
        $model->gol2_d =  $request->totalInvestorValues2;
        $model->gol3 = $request->totalgol3;
        $model->gol3_d =  $request->totalInvestorValues3;
        $model->gol4 = $request->totalgol4;
        $model->gol4_d =  $request->totalInvestorValues4;
        $model->gol5 = $request->totalgol5;
        $model->gol5_d =  $request->totalInvestorValues5;

        $model->tgl_berlaku = $request->waktu;
        $model->id_dasar_tarif = $request->dasartarifmodal;
        $model->aktif = 1;
        $model->tarif_inv = str_replace('"', '', $request->investor1);
        // $model->bagi_hasil = $this->array_string2($request->investor1);
        $model->save();

        return response()->json(['code' => 200, 'message' => 'Success Edit Data']);
    }

    public function GetInvestor($id, $id_gerbang)
    {
        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);


        if ($gerbang->jenis_gerbang == 0) {
            $model = tbl_tarif_open::where('id', $id)->first();
        } else {
            $model = tbl_tarif_exit::where('id', $id)->first();
        }
        return response()->json(compact('model'));
    }

    function split_array($string)
    {
        // Menghilangkan kurung siku di awal dan akhir string
        $cleanedString = trim($string, "[]");

        // Memisahkan string menjadi array berdasarkan koma
        $arrayValue = explode(',', $cleanedString);

        // Membersihkan elemen array dari spasi tambahan
        $arrayValue = array_map('trim', $arrayValue);

        return $arrayValue;
    }


    public function exportClose($id_gerbang)
    {

        $gerbang = tbl_gerbang::where('gerbang_id', $id_gerbang)->first();

        Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = tbl_tarif_exit::query();
        $model->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'tbl_tarif_exit.gerbang_id')
            ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'tbl_tarif_exit.asal_gerbang')
            ->leftjoin('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_exit.id_dasar_tarif');

        $model->select([
            'tbl_tarif_exit.id',
            'gerbang.gerbang_nama as gerbang1',
            'gerbang_asal.gerbang_nama as asalGerbang',
            'tbl_tarif_exit.jenis',
            'tbl_dasar_tarif.dasar_tarif',
            'tbl_dasar_tarif.mulai_berlaku',
            'tbl_tarif_exit.gol1',
            'tbl_tarif_exit.gol1_d',
            'tbl_tarif_exit.gol2',
            'tbl_tarif_exit.gol2_d',
            'tbl_tarif_exit.gol3',
            'tbl_tarif_exit.gol3_d',
            'tbl_tarif_exit.gol4',
            'tbl_tarif_exit.gol4_d',
            'tbl_tarif_exit.gol5',
            'tbl_tarif_exit.gol5_d',
            'tbl_tarif_exit.tarif_inv',
            'tbl_tarif_exit.tgl_berlaku',
        ]);


        $data = $model->get();
        // dd($this->split_array($data[0]->tarif));
        $array = [
            'data' => $data,
            'gerbang' => $gerbang
        ];

        $pdf = Pdf::loadView('admin.pdfClose', $array)->setPaper('a4', 'landscape');

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="exported-pdf.pdf"');
    }
}
