<?php

namespace App\Http\Controllers;

use App\Imports\TarifExitImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenTarifCT extends Controller
{
    public function index(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            if ($gerbang->jenis_gerbang == 0) {
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

                $model = DB::connection('mysql2')
                    ->table('tbl_tarif_open')
                    ->select($selectOpen)
                    ->join('tbl_gerbang', 'tbl_gerbang.gerbang_id', '=', 'tbl_tarif_open.gerbang_id')
                    ->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_open.id_dasar_tarif');
            } else {
                $selectExit = [
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
                ];

                $model = DB::connection('mysql2')
                    ->table('tbl_tarif_exit')
                    ->select($selectExit)
                    ->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'tbl_tarif_exit.gerbang_id')
                    ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'tbl_tarif_exit.asal_gerbang')
                    ->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_exit.id_dasar_tarif');
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
                ->make();
        }
        return view(
            'list.manajemen_tarif',
            [
                'judul' => 'Manajemen Tarif',
                'Cloums' => []
            ]
        );
    }

    public function indexOpen(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            $selectOpen = [
                'tbl_tarif_open.id',
                'tbl_gerbang.gerbang_nama',
                'tbl_dasar_tarif.dasar_tarif',
                DB::raw("FORMAT(tbl_tarif_open.gol1, 0, 'id_ID') as gol1"),
                DB::raw("FORMAT(tbl_tarif_open.gol2, 0, 'id_ID') as gol2"),
                DB::raw("FORMAT(tbl_tarif_open.gol3, 0, 'id_ID') as gol3"),
                DB::raw("FORMAT(tbl_tarif_open.gol4, 0, 'id_ID') as gol4"),
                DB::raw("FORMAT(tbl_tarif_open.gol5, 0, 'id_ID') as gol5"),
                'tbl_tarif_open.tgl_berlaku',
            ];

            $model = DB::connection('mysql2')
                        ->table('tbl_tarif_open')
                        ->select($selectOpen)
                        ->join('tbl_gerbang', 'tbl_gerbang.gerbang_id', '=', 'tbl_tarif_open.gerbang_id')
                        ->join('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_open.id_dasar_tarif');


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
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

        if (request()->ajax()) {

            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $selectedGerbang)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            $selectExit = [
                'tbl_tarif_exit.id',
                'gerbang.gerbang_nama as gerbang1',
                'gerbang_asal.gerbang_nama as asalGerbang',
                'tbl_tarif_exit.jenis',
                'tbl_dasar_tarif.dasar_tarif',
                DB::raw("FORMAT(tbl_tarif_exit.gol1, 0, 'id_ID') as gol1"),
                DB::raw("FORMAT(tbl_tarif_exit.gol2, 0, 'id_ID') as gol2"),
                DB::raw("FORMAT(tbl_tarif_exit.gol3, 0, 'id_ID') as gol3"),
                DB::raw("FORMAT(tbl_tarif_exit.gol4, 0, 'id_ID') as gol4"),
                DB::raw("FORMAT(tbl_tarif_exit.gol5, 0, 'id_ID') as gol5"),
                'tbl_tarif_exit.tgl_berlaku',
            ];

            $model = DB::connection('mysql2')
                        ->table('tbl_tarif_exit')
                        ->select($selectExit)
                        ->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'tbl_tarif_exit.gerbang_id')
                        ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'tbl_tarif_exit.asal_gerbang')
                        ->leftjoin('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'tbl_tarif_exit.id_dasar_tarif');


            return DataTables::of($model)
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button class="btn m-1 btn-warning btn-sm btnEditTarif" id="btnEditTarif" data-url="' . $row->id . '" > <i class="fa fa-edit" ></i> Edit</button>
                        <button class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id . '"> <i class="fa fa-trash"></i> Delete</button>
                        <button class="btn m-1 btn-info btn-sm" id="btnDetailInvestor" data-url="' . $row->id . '"> <i class="fa fa-eye"></i> Investor</button>
                    ';

                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('gerbang_asal.gerbang_nama', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make();
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
                        'title' => 'Jenis',
                        'data' => 'jenis',
                        'name' => 'tbl_tarif_exit.jenis',
                    ],
                    [
                        'title' => 'Dasar Tarif',
                        'data' => 'dasar_tarif',
                        'name' => 'tbl_dasar_tarif.dasar_tarif',
                    ],
                    [
                        'title' => 'Golongan 1',
                        'data' => 'gol1',
                        'name' => 'tbl_tarif_exit.gol1',
                    ],
                    [

                        'title' => 'Golongan 2',
                        'data' => 'gol2',
                        'name' => 'tbl_tarif_exit.gol2',
                    ],
                    [

                        'title' => 'Golongan 3',
                        'data' => 'gol3',
                        'name' => 'tbl_tarif_exit.gol3',
                    ],
                    [

                        'title' => 'Golongan 4',
                        'data' => 'gol4',
                        'name' => 'tbl_tarif_exit.gol4',
                    ],
                    [

                        'title' => 'Golongan 5',
                        'data' => 'gol5',
                        'name' => 'tbl_tarif_exit.gol5',
                    ],
                    [

                        'title' => 'Waktu Berlaku',
                        'data' => 'tgl_berlaku',
                        'name' => 'tbl_tarif_exit.tgl_berlaku',
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


    public function importclose()
    {
        return view(
            'importclose'
        );
    }

    public function importcloseStore(Request $request)
    {
        $gerbang = DB::connection('mysql')
                        ->table('tbl_gerbang')
                        ->where('gerbang_id', $request->gerbangmodal)
                        ->first();

        try {
            $import = new TarifExitImport($gerbang, $request);
            Excel::import($import, $request->file('file'));

            $failed = $import->getFailed();
            $array = [
                'gerbang' => $failed
            ];

            $pdf = Pdf::loadView('admin.pdfFailedClose', $array)->setPaper('a4', 'landscape');

            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="Table Tarif GT ' . $gerbang->gerbang_nama . '.pdf"');


            return response()->json(['code' => 200, 'message' => 'Success Import Data']);
        } catch (Exception $e) {
            return response()->json(['code' => 400, 'message' => $e->getMessage()]);
        }
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
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error Database']);
        }

        DB::connection('mysql2')->table('tbl_tarif_open')->insert([
            'ruas' => $gerbang->ruas_id,
            'gerbang_id' => $request->gerbangmodal,
            'gol1' => $request->totalgol1,
            'gol1_d' => $request->totalInvestorValues1,
            'gol2' => $request->totalgol2,
            'gol2_d' => $request->totalInvestorValues2,
            'gol3' => $request->totalgol3,
            'gol3_d' => $request->totalInvestorValues3,
            'gol4' => $request->totalgol4,
            'gol4_d' => $request->totalInvestorValues4,
            'gol5' => $request->totalgol5,
            'gol5_d' => $request->totalInvestorValues5,
            'tgl_berlaku' => $request->waktu,
            'id_dasar_tarif' => $request->dasartarifmodal,
            'aktif' => 1,
            'tarif_inv' => str_replace('"', '', $request->investor1),
            'bagi_hasil' => str_replace('"', '', $request->investor1),
        ]);

        return response()->json(['code' => 200, 'message' => 'Success Add Data']);
    }


    public function tambahExit(Request $request)
    {
        try {
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

        } catch (\Throwable $th) {
            return response()->json(['code' => 400, 'message' => 'Error Database']);
        }

        DB::connection('mysql2')->table('tbl_tarif_exit')->insert([
            'ruas_id' => $gerbang->ruas_id,
            'gerbang_id' => $request->gerbangmodal,
            'asal_gerbang' => $request->asal_gerbang,
            'jenis' => $request->jenis,
            'gol1' => $request->totalgol1,
            'gol1_d' => $request->totalInvestorValues1,
            'gol2' => $request->totalgol2,
            'gol2_d' => $request->totalInvestorValues2,
            'gol3' => $request->totalgol3,
            'gol3_d' => $request->totalInvestorValues3,
            'gol4' => $request->totalgol4,
            'gol4_d' => $request->totalInvestorValues4,
            'gol5' => $request->totalgol5,
            'gol5_d' => $request->totalInvestorValues5,
            'tgl_berlaku' => $request->waktu,
            'id_dasar_tarif' => $request->dasartarifmodal,
            'aktif' => 1,
            'tarif_inv' => str_replace('"', '', $request->investor1),
        ]);

        return response()->json(['code' => 200, 'message' => 'Success Add Data']);
    }

    public function delete($id_tarif, $id_gerbang)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $id_gerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);


        if ($gerbang->jenis_gerbang == 0) {
            DB::connection('mysql2')->table('tbl_tarif_open')->where('id', $id_tarif)->delete();
        } else {
            $model = DB::connection('mysql2')->table('tbl_tarif_exit')->where('id', $id_tarif)->delete();
        }

        return true;
    }

    public function edit($id, $id_gerbang)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $id_gerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);


        if ($gerbang->jenis_gerbang == 0) {
            $model = DB::connection('mysql2')->table('tbl_tarif_open')->where('id', $id)->first();
        } else {
            $model = DB::connection('mysql2')->table('tbl_tarif_exit')->where('id', $id)->first();
        }

        return response()->json(compact('model'));
    }

    public function update(Request $request)
    {
        try {
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

        } catch (\Throwable $th) {
            return response()->json(['code' => 400, 'message' => 'Error Database']);
        }

        DB::connection('mysql2')->table('tbl_tarif_open')->where('id', $request->id)->update([
            'ruas' => $gerbang->ruas_id,
            'gerbang_id' => $request->gerbangmodal,
            'gol1' => $request->totalgol1,
            'gol1_d' => $request->totalInvestorValues1,
            'gol2' => $request->totalgol2,
            'gol2_d' => $request->totalInvestorValues2,
            'gol3' => $request->totalgol3,
            'gol3_d' => $request->totalInvestorValues3,
            'gol4' => $request->totalgol4,
            'gol4_d' => $request->totalInvestorValues4,
            'gol5' => $request->totalgol5,
            'gol5_d' => $request->totalInvestorValues5,
            'tgl_berlaku' => $request->waktu,
            'id_dasar_tarif' => $request->dasartarifmodal,
            'aktif' => 1,
            'tarif_inv' => str_replace('"', '', $request->investor1),
            'bagi_hasil' => str_replace('"', '', $request->investor1),
        ]);

        return response()->json(['code' => 200, 'message' => 'Success Edit Data']);
    }

    public function updateExit(Request $request)
    {
        try {
            $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $request->gerbangmodal)->first();

            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

        } catch (\Throwable $th) {
            return response()->json(['code' => 400, 'message' => 'Error Database']);
        }

        DB::connection('mysql2')->table('tbl_tarif_exit')->where('id', $request->id)->update([
            'ruas_id' => $gerbang->ruas_id,
            'gerbang_id' => $request->gerbangmodal,
            'asal_gerbang' => $request->asal_gerbang,
            'jenis' => $request->jenis,
            'gol1' => $request->totalgol1,
            'gol1_d' => $request->totalInvestorValues1,
            'gol2' => $request->totalgol2,
            'gol2_d' => $request->totalInvestorValues2,
            'gol3' => $request->totalgol3,
            'gol3_d' => $request->totalInvestorValues3,
            'gol4' => $request->totalgol4,
            'gol4_d' => $request->totalInvestorValues4,
            'gol5' => $request->totalgol5,
            'gol5_d' => $request->totalInvestorValues5,
            'tgl_berlaku' => $request->waktu,
            'id_dasar_tarif' => $request->dasartarifmodal,
            'aktif' => 1,
            'tarif_inv' => str_replace('"', '', $request->investor1),
        ]);

        return response()->json(['code' => 200, 'message' => 'Success Edit Data']);
    }

    public function GetInvestor($id, $id_gerbang)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $id_gerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        if ($gerbang->jenis_gerbang == 0 || $gerbang->jenis_gerbang == 4) {
            $model = DB::connection('mysql2')->table('tbl_tarif_open')->where('id', $id)->first();
        } else {
            $model = DB::connection('mysql2')->table('tbl_tarif_exit')->where('id', $id)->first();
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
        $gerbang = DB::connection('mysql')
                    ->table('tbl_gerbang')
                    ->where('gerbang_id', $id_gerbang)
                    ->leftjoin('tbl_ruas', 'tbl_gerbang.ruas_id', '=', 'tbl_ruas.ruas_id')
                    ->select([
                        'tbl_ruas.ruas_nama',
                        'tbl_gerbang.ruas_id',
                        'tbl_gerbang.host',
                        'tbl_gerbang.port',
                        'tbl_gerbang.database',
                        'tbl_gerbang.user',
                        'tbl_gerbang.pass',
                        'tbl_gerbang.gerbang_nama'
                    ])
                    ->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $dasar_tarif = DB::connection('mysql2')
                        ->table('tbl_dasar_tarif')
                        ->orderBy('mulai_berlaku', 'DESC')
                        ->first();

        $data = DB::connection('mysql2')->table('view_tarif')
                ->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'view_tarif.gerbang_id')
                ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'view_tarif.asal_gerbang')
                ->leftJoin('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'view_tarif.id_dasar_tarif')
                ->select([
                    'view_tarif.id',
                    'gerbang.gerbang_nama as gerbang1',
                    'gerbang_asal.gerbang_nama as asalGerbang',
                    'view_tarif.jenis',
                    'tbl_dasar_tarif.dasar_tarif',
                    'tbl_dasar_tarif.mulai_berlaku',
                    'view_tarif.gol1',
                    'view_tarif.gol1_d',
                    'view_tarif.gol2',
                    'view_tarif.gol2_d',
                    'view_tarif.gol3',
                    'view_tarif.gol3_d',
                    'view_tarif.gol4',
                    'view_tarif.gol4_d',
                    'view_tarif.gol5',
                    'view_tarif.gol5_d',
                    'view_tarif.tarif_inv',
                    'view_tarif.tgl_berlaku',
                ])
                ->get();

        $array = [
            'data' => $data,
            'gerbang' => $gerbang,
            'dasar_tarif' => $dasar_tarif
        ];

        // $pdf = PDF::loadView('admin.pdfClose', $array)->setPaper('f4', 'landscape');
        $pdf = PDF::loadView('admin.pdfClose', $array)->setPaper([0, 0, 600, 1200], 'landscape');

        // Set options for the PDF
        $options = [
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150,
            'fontHeightRatio' => 1.0,
            'isJavascriptEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'fitToPage' => true, // This option ensures that content fits the page
        ];

        $pdf->setOptions($options);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Table Tarif GT ' . $gerbang->gerbang_nama . '.pdf"');
    }

    public function viewClose($id_gerbang)
    {
        $gerbang = DB::connection('mysql')
                    ->table('tbl_gerbang')
                    ->where('gerbang_id', $id_gerbang)
                    ->leftjoin('tbl_ruas', 'tbl_gerbang.ruas_id', '=', 'tbl_ruas.ruas_id')
                    ->select([
                        'tbl_ruas.ruas_nama',
                        'tbl_gerbang.ruas_id',
                        'tbl_gerbang.host',
                        'tbl_gerbang.port',
                        'tbl_gerbang.database',
                        'tbl_gerbang.user',
                        'tbl_gerbang.pass',
                        'tbl_gerbang.gerbang_nama'
                    ])
                    ->first();


        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $dasar_tarif = DB::connection('mysql2')
                        ->table('tbl_dasar_tarif')
                        ->orderBy('mulai_berlaku', 'DESC')
                        ->first();


        $data = DB::connection('mysql2')->table('view_tarif')
                    ->join('tbl_gerbang as gerbang', 'gerbang.gerbang_id', '=', 'view_tarif.gerbang_id')
                    ->join('tbl_gerbang as gerbang_asal', 'gerbang_asal.gerbang_id', '=', 'view_tarif.asal_gerbang')
                    ->leftJoin('tbl_dasar_tarif', 'tbl_dasar_tarif.id_dasar_tarif', '=', 'view_tarif.id_dasar_tarif')
                    ->select([
                        'view_tarif.id',
                        'gerbang.gerbang_nama as gerbang1',
                        'gerbang_asal.gerbang_nama as asalGerbang',
                        'view_tarif.jenis',
                        'tbl_dasar_tarif.dasar_tarif',
                        'tbl_dasar_tarif.mulai_berlaku',
                        'view_tarif.gol1',
                        'view_tarif.gol1_d',
                        'view_tarif.gol2',
                        'view_tarif.gol2_d',
                        'view_tarif.gol3',
                        'view_tarif.gol3_d',
                        'view_tarif.gol4',
                        'view_tarif.gol4_d',
                        'view_tarif.gol5',
                        'view_tarif.gol5_d',
                        'view_tarif.tarif_inv',
                        'view_tarif.tgl_berlaku',
                    ])
                    ->get();

        $returnHTML = view('admin.viewClose', compact('data', 'gerbang', 'dasar_tarif'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
