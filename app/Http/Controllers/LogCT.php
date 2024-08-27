<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LogCT extends Controller
{
    public function getLog(){

        if (request()->ajax()) {
            $q = DB::connection('mysql')->table('tbl_log_operational')->query();

            if(request()->filled('kategori_id') && request()->kategori_id != '*') {
                $q->where('kategori', request()->kategori_id);
            }

            return DataTables::of($q)
            ->addColumn('jabatan', function ($row) {
                $jabatan_id = $row->id_jabatan;

                $data = DB::connection('mysql')->table('tbl_jabatan')->where('jabatan_id', $jabatan_id)->first();

                $jabatan = $data->nama_jabatan;

                return $jabatan;
            })
            ->addColumn('gerbang', function ($row) {
                // Split the comma-separated IDs into an array
                $gerbang_id = $row->gerbang_id;

                // Retrieve related data from Table2Model based on the IDs
                $data = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $gerbang_id)->first();

                // // Create a string to display the related data
                $gerbang = $data ? $data->gerbang_nama : '';

                return $gerbang;
            })
            ->addColumn('nama_petugas', function ($row) {
                // Split the comma-separated IDs into an array
                $npp_no = $row->npp_no;

                // Retrieve related data from Table2Model based on the IDs
                $data = DB::connection('mysql')->table('tbl_pegawai')->where('npp_no', $npp_no)->first();
                // Create a string to display the related data
                $nama_petugas = $data ? $data->nama_pegawai : '';

                return $nama_petugas;
            })
            ->addColumn('kategori', function ($row) {
                // Split the comma-separated IDs into an array
                $kategori_id = $row->kategori;

                switch ($kategori_id) {
                    case 1:
                        $kategori = 'Petugas';
                        break;
                    case 2:
                        $kategori = 'Tarif';
                        break;
                    case 3:
                        $kategori = 'Kartu Dinas';
                        break;
                    case 4:
                        $kategori = 'Kartu Pass Pull';
                        break;
                    case 5:
                        $kategori = 'Blacklist';
                        break;
                    default:
                        $kategori = 'UNKNOWNN';
                        break;
                }

                return $kategori;
            })
            ->make();
        }

        return view(
            'admin.logs.Logs',
            [
                'judul' => 'Data Petugas',
                'Columns' => [
                    [
                        'title' => 'NPP',
                        'data' => 'npp_no',
                        'name' => 'tbl_log_operasional.npp_no',
                    ],
                    [
                        'title' => 'Nama',
                        'data' => 'nama_petugas',
                        'name' => 'nama_petugas',
                    ],
                    [
                        'title' => 'Jabatan',
                        'data' => 'jabatan',
                        'name' => 'jabatan',
                    ],
                    [
                        'title' => 'Gerbang',
                        'data' => 'gerbang',
                        'name' => 'gerbang',
                    ],
                    [
                        'title' => 'Waktu',
                        'data' => 'waktu',
                        'name' => 'tbl_log_operasional.waktu',
                    ],
                    [
                        'title' => 'Kategori',
                        'data' => 'kategori',
                        'name' => 'kategori',
                    ],
                    [
                        'title' => 'Event',
                        'data' => 'event',
                        'name' => 'tbl_log_operasional.event',
                    ],
                    [
                        'title' => 'Keterangan',
                        'data' => 'keterangan',
                        'name' => 'tbl_log_petugas.keterangan',
                    ]
                ]
            ]
        );
    }
}
