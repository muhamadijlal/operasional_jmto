<?php

namespace App\Http\Controllers;

use App\Imports\PetugasImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PetugasCT extends Controller
{
    public function BuatPetugas()
    {
        
        if (request()->ajax()) {
            if (request()->gerbang_id) {
                $gerbang = DB::connection('mysql')
                            ->table('tbl_gerbang')
                            ->where('gerbang_id', request()->gerbang_id)
                            ->first();
    
                Config::set('database.connections.mysql2.host', $gerbang->host);
                Config::set('database.connections.mysql2.port', $gerbang->port);
                Config::set('database.connections.mysql2.database', $gerbang->database);
                Config::set('database.connections.mysql2.username', $gerbang->user);
                Config::set('database.connections.mysql2.password', $gerbang->pass);
    
                $q = DB::connection('mysql2')
                        ->table('tbl_pegawai')
                        ->get();
                
                return DataTables::of($q)
                    ->addColumn('jabatan', function ($row) {
                        if ($row->jabatan_id == 4) {
                            $jabatan = 'Teknisi';
                        } elseif ($row->jabatan_id == 0) {
                            $jabatan = 'MA';
                        } elseif ($row->jabatan_id == 1) {
                            $jabatan = 'KBT';
                        } elseif ($row->jabatan_id == 2) {
                            $jabatan = 'KSPT';
                        } elseif ($row->jabatan_id == 3) {
                            $jabatan = 'PLT';
                        }

                        return $jabatan;
                    })
                    ->addColumn('penempatan', function ($row) {
                        $ids = explode(',', $row->penempatan_gerbang);

                        $relatedData = DB::connection('mysql')
                                        ->table('tbl_gerbang')
                                        ->whereIn('gerbang_id', $ids)
                                        ->pluck('gerbang_nama')
                                        ->toArray();

                        $penempatan = implode(', ', $relatedData);

                        return $penempatan;
                    })->addColumn('action', function ($row) {
                        $btn = '
                                <a href="#" class="btn m-1 btn-warning btn-sm btnEditPetugas" id="btnEditPetugas" data-url="' . $row->npp_no . '" > <i class="fa fa-edit" ></i> Edit</a>
                                <a href="#" class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->npp_no . '"> <i class="fa fa-trash"></i> Delete</a>
                            ';

                        return $btn;
                    })
                    ->make();
            }
        }

        return view(
            'admin.petugas.buatPetugas',
            [
                'judul' => 'Buat Petugas',
                'Cloums' => [
                    [
                        'title' => 'NPP Petugas',
                        'data' => 'npp_no',
                        'name' => 'tbl_pegawai.npp_no',
                    ],
                    [
                        'title' => 'Nama Petugas',
                        'data' => 'nama_pegawai',
                        'name' => 'tbl_pegawai.nama_pegawai',
                    ],

                    [
                        'title' => 'Jabatan',
                        'data' => 'jabatan',
                        'name' => 'jabatan',
                    ],
                    [
                        'title' => 'Kode Tugas',
                        'data' => 'kode_tugas',
                        'name' => 'tbl_pegawai.kode_tugas',
                    ],
                    [
                        'title' => 'Penempatan',
                        'data' => 'penempatan',
                        'name' => 'penempatan',
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

    public function BuatPetugasTambah(Request $request)
    {
        $gerbang = DB::connection('mysql')
                        ->table('tbl_gerbang')
                        ->where('gerbang_id', request()->gerbang_conn)
                        ->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $request->validate([
            'npp' => 'required|unique:tbl_pegawai,npp_no',
            'nama_petugas' => 'required',
            'jabatan' => 'required',
            'inisial_petugas' => 'required|unique:tbl_pegawai,kode_tugas',
            'gerbang_penempatan' => 'required'
        ]);

        DB::connection('mysql2')
            ->table('tbl_pegawai')
            ->insert([
                'npp_no' => $request->npp,
                // 'email' => '',
                'nama_pegawai' => $request->nama_petugas,
                'jabatan_id' => $request->jabatan,
                'password' => $request->npp,
                'gerbang_id' => '-',
                'kode_tugas' => $request->inisial_petugas,
                'penempatan_gerbang' => $request->gerbang_penempatan
            ]);

        return response()->json(['code' => 200, 'message' => 'Success Add Data']);
    }

    public function BuatPetugasEdit($npp, $gerbang_conn)
    {
        $gerbang = DB::connection('mysql')
                        ->table('tbl_gerbang')
                        ->where('gerbang_id', $gerbang_conn)
                        ->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $model = DB::connection('mysql2')
                    ->table('tbl_pegawai')
                    ->where('npp_no', $npp)
                    ->first();

        return response()->json(compact('model'));
    }

    public function BuatPetugasUpdate(Request $request, $id)
    {
        $gerbang = DB::connection('mysql')
                        ->table('tbl_gerbang')
                        ->where('gerbang_id', $request->gerbang_conn)
                        ->first();

        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $request->validate([
            'npp' => [
                'required',
                Rule::unique('tbl_pegawai', 'npp_no')
                    ->ignore($request->id, 'npp_no'),
            ],
            'nama_petugas' => 'required',
            'jabatan' => 'required',
            'inisial_petugas' => [
                'required',
                Rule::unique('tbl_pegawai', 'kode_tugas')
                    ->ignore($request->id, 'npp_no'),
            ],
            'gerbang_penempatan' => 'required',
        ]);

        DB::connection('mysql2')
            ->table('tbl_pegawai')
            ->where('npp_no', $id)
            ->update([
                'npp_no' => $request->npp,
                // 'email' => '',
                'nama_pegawai' => $request->nama_petugas,
                'jabatan_id' => $request->jabatan,
                'password' => $request->npp,
                'gerbang_id' => '-',
                'kode_tugas' => $request->inisial_petugas,
                'penempatan_gerbang' => $request->gerbang_penempatan
            ]);

        return response()->json(['code' => 200, 'message' => 'Success Update Data']);
    }

    public function BuatPetugasDelete($id, $gerbang_conn)
    {
        $gerbang = DB::connection('mysql')
                        ->table('tbl_gerbang')
                        ->where('gerbang_id', $gerbang_conn)
                        ->first();

        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        DB::connection('mysql2')->table('tbl_pegawai')->where('npp_no', $id)->delete();

        return response()->json(['code' => 200, 'message' => 'Success Delete Data']);
    }

    public function BuatKartuOps(){
        return view("admin.petugas.BuatKartuOps");
    }

    public function DataPetugas(){
        if (request()->ajax()) {
            $q = DB::connection('mysql')->table('tbl_pegawai')->query();

            if (request()->filled('jabatan_id') && request()->filled('gerbang_id')) {
                $q->where('gerbang_id', request()->gerbang_id)->where('jabatan_id', request()->jabatan_id);
            } else {
                $q->where('jabatan_id', '!=', 1);
            }

            return DataTables::of($q)
                ->addColumn('jabatan', function ($row) {
                    $jabatan_id = $row->jabatan_id;

                    $data = DB::connection('mysql')->table('tbl_jabatan')->where('jabatan_id', $jabatan_id)->first();

                    $jabatan = $data->nama_jabatan;

                    return $jabatan;
                })
                ->addColumn('penempatan', function ($row) {
                    // Split the comma-separated IDs into an array
                    $ids = explode(',', $row->penempatan_gerbang);

                    // Retrieve related data from Table2Model based on the IDs
                    $relatedData = DB::connection('mysql')->table('tbl_gerbang')->whereIn('gerbang_id', $ids)->pluck('gerbang_nama')->toArray();

                    // Create a string to display the related data
                    $penempatan = implode(', ', $relatedData);

                    return $penempatan;
                })
                ->addColumn('gerbang', function ($row) {
                    // Split the comma-separated IDs into an array
                    $gerbang_id = $row->gerbang_id;

                    // Retrieve related data from Table2Model based on the IDs
                    $relatedData = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $gerbang_id)->first();

                    // // Create a string to display the related data
                    $gerbang = $relatedData->gerbang_nama;

                    return $gerbang;
                })
                ->make();
        }

        return view(
            'admin.petugas.DataPetugas',
            [
                'judul' => 'Data Petugas',
                'Columns' => [
                    [
                        'title' => 'NPP Petugas',
                        'data' => 'npp_no',
                        'name' => 'tbl_pegawai.npp_no',
                    ],
                    [
                        'title' => 'Nama Petugas',
                        'data' => 'nama_pegawai',
                        'name' => 'tbl_pegawai.nama_pegawai',
                    ],
                    [
                        'title' => 'Gerbang',
                        'data' => 'gerbang',
                        'name' => 'gerbang',
                    ],
                    [
                        'title' => 'Jabatan',
                        'data' => 'jabatan',
                        'name' => 'jabatan',
                    ],
                    [
                        'title' => 'Kode Tugas',
                        'data' => 'kode_tugas',
                        'name' => 'tbl_pegawai.kode_tugas',
                    ],
                    [
                        'title' => 'Penempatan',
                        'data' => 'penempatan',
                        'name' => 'penempatan',
                    ]
                ]
            ]
        );
    }

    public function importPetugas(Request $request)
    {
        try {
            $import = new PetugasImport($request);
            Excel::import($import, $request->file('file'));

            $error = count($import->getFailed());

            return response()->json(['code' => 200, 'message' => 'Success Import Data', 'error' => $error]);
        } catch (Exception $e) {
            return response()->json(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
}
