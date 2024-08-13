<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuatPetugasTambahStore;
use App\Http\Requests\BuatPetugasUpdateStore;
use App\Models\tbl_gerbang;
use App\Models\tbl_pegawai;
use App\Models\tbl_pegawai2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Svg\Tag\Rect;
use Yajra\DataTables\Facades\DataTables;

class PetugasCT extends Controller
{
    public function BuatPetugas()
    {

        if (request()->ajax()) {
            return DataTables::of(tbl_pegawai::query())
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
                    // Split the comma-separated IDs into an array
                    $ids = explode(',', $row->penempatan_gerbang);

                    // Retrieve related data from Table2Model based on the IDs
                    $relatedData = tbl_gerbang::whereIn('gerbang_id', $ids)->pluck('gerbang_nama')->toArray();

                    // Create a string to display the related data
                    $penempatan = implode(', ', $relatedData);

                    return $penempatan;
                })->addColumn('action', function ($row) {
                    $btn = '
                            <a href="#" class="btn m-1 btn-warning btn-sm btnEditPetugas" id="btnEditPetugas" data-url="' . $row->id . '" > <i class="fa fa-edit" ></i> Edit</a>
                            <a href="#" class="delete btn m-1 btn-danger btn-sm" data-url="' . $row->id . '"> <i class="fa fa-trash"></i> Delete</a>
                        ';

                    return $btn;
                })
                ->make();
        }

        return view(
            'admin.petugas.buatPetugas',
            [
                'judul' => 'Buat Petugas',
                // 'BtnInfo' => [
                //     'url' => '/admin/document/create',
                //     'name' => "Add Dasar Tarif"
                // ],
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

    public function BuatPetugasTambah(BuatPetugasTambahStore $request)
    {

        $model = new tbl_pegawai;
        $model->npp_no = $request->npp;
        $model->email = '';
        $model->nama_pegawai = $request->nama_petugas;
        $model->jabatan_id = $request->jabatan;
        $model->password = $request->npp;
        $model->gerbang_id = '-';
        $model->kode_tugas = $request->inisial_petugas;
        $model->penempatan_gerbang = $request->gerbang_penempatan;
        $model->save();

        return response()->json(['code' => 200, 'message' => 'Success Add Data']);
    }

    public function BuatPetugasEdit($id)
    {
        $model = tbl_pegawai::find($id);
        return response()->json(compact('model'));
    }

    public function BuatPetugasUpdate(BuatPetugasUpdateStore $request, $id)
    {

        $model =  tbl_pegawai::find($id);
        $model->npp_no = $request->npp;
        $model->email = '';
        $model->nama_pegawai = $request->nama_petugas;
        $model->jabatan_id = $request->jabatan;
        $model->password = $request->npp;
        $model->gerbang_id = '-';
        $model->kode_tugas = $request->inisial_petugas;
        $model->penempatan_gerbang = $request->gerbang_penempatan;
        $model->save();

        return response()->json(['code' => 200, 'message' => 'Success Update Data']);
    }

    public function BuatPetugasDelete($id)
    {
        $model = tbl_pegawai::find($id);
        $model->delete();
        return response()->json(['code' => 200, 'message' => 'Success Delete Data']);
    }

    public function BuatPetugasSycron()
    {

        $modal = tbl_gerbang::where('gerbang_id', '02')->get();
        $pegawai = tbl_pegawai::all();

        foreach ($modal as $key => $gerbang) {
            Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
            Config::set('database.connections.mysql2.host', $gerbang->host);
            Config::set('database.connections.mysql2.port', $gerbang->port);
            Config::set('database.connections.mysql2.database', $gerbang->database);
            Config::set('database.connections.mysql2.username', $gerbang->user);
            Config::set('database.connections.mysql2.password', $gerbang->pass);

            tbl_pegawai2::truncate();
            tbl_pegawai2::insert($pegawai->toArray());
        }



        return response()->json(['code' => 200, 'message' => 'Success Syincron Data']);
    }

    public function BuatKartuOps(){
        return view("admin.petugas.BuatKartuOps");
    }

    public function DataPetugas(){
        if (request()->ajax()) {
            $q = tbl_pegawai::query()->where('jabatan_id', '!=', 1);

            return DataTables::of($q)->make();
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
                        'data' => 'gerbang_id',
                        'name' => 'tbl_pegawai.gerbang_id',
                    ],
                    [
                        'title' => 'Jabatan',
                        'data' => 'jabatan_id',
                        'name' => 'tbl_pegawai.jabatan_id',
                    ],
                    [
                        'title' => 'Kode Tugas',
                        'data' => 'kode_tugas',
                        'name' => 'tbl_pegawai.kode_tugas',
                    ],
                    [
                        'title' => 'Penempatan',
                        'data' => 'penempatan_gerbang',
                        'name' => 'tbl_pegawai.penempatan_gerbang',
                    ]
                ]
            ]
        );
    }
}
