<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DurasiCT extends Controller
{
    // Jumlah golongan kendaraan (Gol I - V)
    private const JUMLAH_GOLONGAN = 5;

    /**
     * Set koneksi database gerbang (mysql2) berdasarkan data koneksi
     * yang tersimpan di tbl_gerbang pada database pusat (jmj_bcds).
     */
    private function setKoneksiGerbang($gerbangId)
    {
        $gerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_id', $gerbangId)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        return $gerbang;
    }

    /**
     * Pecah string durasi ("30,40,50,50,50") menjadi array per golongan.
     */
    private function pecahDurasi($durasi)
    {
        $parts = ($durasi === null || $durasi === '') ? [] : explode(',', $durasi);

        $gol = [];
        for ($i = 0; $i < self::JUMLAH_GOLONGAN; $i++) {
            $gol[$i] = isset($parts[$i]) ? trim($parts[$i]) : '';
        }

        return $gol;
    }

    /**
     * Gabungkan input gol1..gol5 dari form menjadi string durasi comma-separated.
     */
    private function gabungDurasi(Request $request)
    {
        $gol = [];
        for ($i = 1; $i <= self::JUMLAH_GOLONGAN; $i++) {
            $gol[] = (int) $request->input('gol' . $i, 0);
        }

        return implode(',', $gol);
    }

    public function index(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');

        if ($selectedGerbang && request()->ajax()) {
            $this->setKoneksiGerbang($selectedGerbang);

            // Join asal_gerbang ke tbl_gerbang (gerbang_id) di database tujuan
            // untuk menampilkan nama gerbang asal.
            $query = DB::connection('mysql2')->table('tbl_durasi as d')
                ->leftJoin('tbl_gerbang as g', 'd.asal_gerbang', '=', 'g.gerbang_id')
                ->select('d.gerbang_id', 'd.asal_gerbang', 'd.durasi', 'g.gerbang_nama as nama_asal_gerbang');

            return DataTables::of($query)
                ->addColumn('gol1', fn ($row) => $this->pecahDurasi($row->durasi)[0])
                ->addColumn('gol2', fn ($row) => $this->pecahDurasi($row->durasi)[1])
                ->addColumn('gol3', fn ($row) => $this->pecahDurasi($row->durasi)[2])
                ->addColumn('gol4', fn ($row) => $this->pecahDurasi($row->durasi)[3])
                ->addColumn('gol5', fn ($row) => $this->pecahDurasi($row->durasi)[4])
                ->addColumn('action', function ($row) {
                    return '
                            <a href="#" class="btn m-1 btn-warning btn-sm btnEditDurasi" data-asal="' . $row->asal_gerbang . '"> <i class="fa fa-edit"></i> Edit</a>
                            <a href="#" class="delete btn m-1 btn-danger btn-sm" data-asal="' . $row->asal_gerbang . '"> <i class="fa fa-trash"></i> Delete</a>
                        ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view(
            'admin.durasi.list',
            [
                'judul' => 'Durasi',
                'Cloums' => [
                    [
                        'title' => 'Kode Asal',
                        'data' => 'asal_gerbang',
                        'name' => 'd.asal_gerbang',
                    ],
                    [
                        'title' => 'Asal Gerbang',
                        'data' => 'nama_asal_gerbang',
                        'name' => 'g.gerbang_nama',
                    ],
                    [
                        'title' => 'Gol I',
                        'data' => 'gol1',
                        'name' => 'gol1',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                    [
                        'title' => 'Gol II',
                        'data' => 'gol2',
                        'name' => 'gol2',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                    [
                        'title' => 'Gol III',
                        'data' => 'gol3',
                        'name' => 'gol3',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                    [
                        'title' => 'Gol IV',
                        'data' => 'gol4',
                        'name' => 'gol4',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                    [
                        'title' => 'Gol V',
                        'data' => 'gol5',
                        'name' => 'gol5',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                    [
                        'title' => 'Aksi',
                        'data' => 'action',
                        'name' => 'action',
                        'orderable' => false,
                        'searchable' => false,
                    ],
                ],
            ]
        );
    }

    public function tambah(Request $request)
    {
        $this->setKoneksiGerbang($request->gerbangmodal);

        DB::connection('mysql2')->table('tbl_durasi')->insert([
            'gerbang_id' => $request->gerbangmodal,
            'asal_gerbang' => $request->asal_gerbang,
            'durasi' => $this->gabungDurasi($request),
        ]);

        return true;
    }

    public function edit($asal_gerbang, $id_gerbang)
    {
        $this->setKoneksiGerbang($id_gerbang);

        $row = DB::connection('mysql2')->table('tbl_durasi as d')
            ->leftJoin('tbl_gerbang as g', 'd.asal_gerbang', '=', 'g.gerbang_id')
            ->where('d.gerbang_id', $id_gerbang)
            ->where('d.asal_gerbang', $asal_gerbang)
            ->select('d.gerbang_id', 'd.asal_gerbang', 'd.durasi', 'g.gerbang_nama as nama_asal_gerbang')
            ->first();

        $model = [
            'gerbang_id' => $row->gerbang_id,
            'asal_gerbang' => $row->asal_gerbang,
            'nama_asal_gerbang' => $row->nama_asal_gerbang,
            'durasi' => $row->durasi,
            'gol' => $this->pecahDurasi($row->durasi),
        ];

        return response()->json(compact('model'));
    }

    public function update(Request $request)
    {
        $this->setKoneksiGerbang($request->gerbangmodal);

        DB::connection('mysql2')->table('tbl_durasi')
            ->where('gerbang_id', $request->gerbangmodal)
            ->where('asal_gerbang', $request->asal_gerbang)
            ->update([
                'durasi' => $this->gabungDurasi($request),
            ]);

        return true;
    }

    public function delete($asal_gerbang, $id_gerbang)
    {
        $this->setKoneksiGerbang($id_gerbang);

        DB::connection('mysql2')->table('tbl_durasi')
            ->where('gerbang_id', $id_gerbang)
            ->where('asal_gerbang', $asal_gerbang)
            ->delete();

        return true;
    }
}
