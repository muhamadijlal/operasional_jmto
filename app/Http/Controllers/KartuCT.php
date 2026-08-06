<?php

namespace App\Http\Controllers;

use App\Jobs\InsertBlacklistToGerbangJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class KartuCT extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $q = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu');

            if (request()->filled('ruas')) {
                $q->where('ruas', strtolower(request()->ruas));
            }

            if (request()->filled('ktp_jenis_id') && request()->status != '*') {
                $q->where('ktp_jenis_id', request()->ktp_jenis_id);
            }

            if (request()->filled('status') && request()->status != '*') {
                $q->where('status', request()->status);
            }

            if (request()->filled('tgl_terbit')) {
                $tgl_terbit = date('Y-m-d', strtotime(request()->tgl_terbit));
                $q->where('tgl_terbit', $tgl_terbit);
            }

            if (request()->filled('tgl_kadaluarsa')) {
                $tgl_kadaluarsa = date('Y-m-d', strtotime(request()->tgl_kadaluarsa));
                $q->where('tgl_kadaluarsa', $tgl_kadaluarsa);
            }

            if (request()->filled('search')) {
                $searchValue = request()->search;
                $q->where(function ($query) use ($searchValue) {
                    $query->where('nama', 'like', "%{$searchValue}%")
                        ->orWhere('no_registrasi', 'like', "%{$searchValue}%")
                        ->orWhere('no_referensi', 'like', "%{$searchValue}%");
                });
            }

            $query = $q->get();

            return DataTables::of($query)
                ->addColumn('jenis', function ($row) {
                    if ($row->ktp_jenis_id == 1) {
                        $jenis = 'Operasional';
                    } else if ($row->ktp_jenis_id == 2) {
                        $jenis = 'Karyawan';
                    } else if ($row->ktp_jenis_id == 3) {
                        $jenis = 'Mitra';
                    } else {
                        $jenis = 'UNKNOWN';
                    }

                    return $jenis;
                })
                ->addColumn('ruas', function ($row) {

                    switch ($row->ruas) {
                        case 'b001':
                            $ruas = '<div class="d-flex gap-1">
                                        <span style="background-color:blue;" class="badge rounded-pill">JMJ</span>
                                    </div>';
                            break;
                        default:
                            $ruas = '<span style="background-color:blue;" class="badge rounded-pill">Unknown</span>';
                            break;
                    }

                    return $ruas;
                })
                ->addColumn('tgl_terbit', function ($row) {
                    $date_formatted = date('d F Y', strtotime($row->tgl_terbit));

                    return $date_formatted;
                })
                ->addColumn('tgl_kadaluarsa', function ($row) {
                    $date_formatted = date('d F Y', strtotime($row->tgl_kadaluarsa));

                    return $date_formatted;
                })
                ->addColumn('no_ref', function ($row) {
                    $no_ref =  $row->no_referensi ? $row->no_referensi : '';

                    return $no_ref;
                })
                ->addColumn('status', function ($row) {
                    switch ($row->status) {
                        case 1:
                            $status = '<span class="badge rounded-pill bg-success">Aktif</span>';
                            break;
                        case 2:
                            $status = '<span class="badge rounded-pill bg-danger">Blacklist</span>';
                            break;
                        case 3:
                            $status = '<span class="badge rounded-pill bg-warning">Draft</span>';
                            break;
                        default:
                            $status = '<span class="badge rounded-pill bg-warning">UNKNOWN</span>';
                            break;
                    }

                    return $status;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 2) {
                        $btn = '
                        <div class="d-flex">
                            <div class="d-flex">
                                <a href="#" class="btn m-1 btn-success btn-sm" id="whitelist" data-id="' . $row->id . '"><i class="fa-solid fa-check"></i></a>
                                <a href="#" class="btn m-1 btn-warning btn-sm" onclick="handleEdit(' . $row->id . ')"><i class="fa-solid fa-pencil"></i></a>
                            </div>
                        </div>
                    ';
                    } else {
                        $btn = '
                        <div class="d-flex">
                            <a href="#" class="btn m-1 btn-danger btn-sm" id="blacklist" data-id="' . $row->id . '"><i class="fa-solid fa-ban"></i></a>
                            <a href="#" class="btn m-1 btn-warning btn-sm" onclick="handleEdit(' . $row->id . ')"><i class="fa-solid fa-pencil"></i></a>
                        </div>
                    ';
                    }

                    return $btn;
                })
                ->rawColumns(['ruas', 'status', 'action'])
                ->make();
        }

        return view('admin.kartu.penerbitan', [
            'judul' => 'Penerbitan kartu',
            'Columns' => [
                [
                    'title' => 'Nama Kartu',
                    'data' => 'nama',
                    'name' => 'tbl_penerbitan_kartu.nama'
                ],
                [
                    'title' => 'UID',
                    'data' => 'ktp_id',
                    'name' => 'tbl_penerbitan_kartu.ktp_id'
                ],
                [
                    'title' => 'No Kartu',
                    'data' => 'no_registrasi',
                    'name' => 'tbl_penerbitan_kartu.no_registrasi',
                ],
                [
                    'title' => 'No Ref',
                    'data' => 'no_ref',
                    'name' => 'no_ref',
                ],
                [
                    'title' => 'Jenis',
                    'data' => 'jenis',
                    'name' => 'jenis',
                ],
                [
                    'title' => 'Tgl Terbit',
                    'data' => 'tgl_terbit',
                    'name' => 'tgl_terbit',
                ],
                [
                    'title' => 'Tgl Kadaluarsa',
                    'data' => 'tgl_kadaluarsa',
                    'name' => 'tgl_kadaluarsa',
                ],
                [
                    'title' => 'ruas',
                    'data' => 'ruas',
                    'name' => 'ruas'
                ],
                [
                    'title' => 'status',
                    'data' => 'status',
                    'name' => 'status',
                ],
                [
                    'title' => 'Aksi',
                    'data' => 'action',
                    'name' => 'action',
                ],
            ]
        ]);
    }

    public function blacklist_ktp($id)
    {
        try {
            // Gunakan DB::transaction() untuk otomatis menangani commit dan rollback
            DB::connection('integrasi_bcds')->transaction(function () use ($id) {

                // Ambil data terbaru dari tbl_penerbitan_kartu
                $row = DB::connection('integrasi_bcds')
                    ->table('tbl_penerbitan_kartu')
                    ->where('id', $id)
                    ->first();

                // Proses insert ke tbl_blacklist
                $uuid = hexdec($this->formatEndian($row->ktp_id));
                $currentTimestamp = strtotime(now());

                $inserted = DB::connection('integrasi_bcds')
                    ->table('tbl_blacklist')
                    ->insert([
                        'uuid' => $uuid,
                        'no_registrasi' => $row->no_registrasi,
                        'info' => $row->nama,
                        'jenis_ktp' => $row->ktp_jenis_id,
                        'tick' => $currentTimestamp,
                        'penempatan_gerbang' => $row->penempatan_gerbang,
                    ]);

                // Update tbl_penerbitan_kartu
                DB::connection('integrasi_bcds')
                    ->table('tbl_penerbitan_kartu')
                    ->where('id', $id)
                    ->update(['status' => 2]);

                if (!$inserted) {
                    throw new \Exception('Gagal menambahkan data ke tbl_blacklist.');
                }
            });

            return response(['status' => 200, 'message' => "Data berhasil di blacklist"]);
        } catch (\Exception $e) {
            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    public function sync_blacklist()
    {
        $maxRecords = 500;
        $processed = 0;

        try {
            // Ambil data blacklist dari DB integrasi_bcds
            DB::connection('integrasi_bcds')
                ->table('tbl_blacklist')
                ->where('sync', 0)
                ->orderBy('no_registrasi')
                ->chunk(50, function ($dataBlacklist) use (&$processed, $maxRecords) {
                    foreach ($dataBlacklist as $blacklist) {
                        if ($processed >= $maxRecords) {
                            return false; // Stop chunking
                        }

                        $gerbangIds = explode(',', $blacklist->penempatan_gerbang);

                        // Track database tujuan yang sudah diinsert agar tidak insert ulang
                        $insertedDbs = [];

                        foreach ($gerbangIds as $gerbangId) {
                            // Ambil credential berdasarkan gerbang ID
                            $credential = DB::connection('integrasi_bcds')
                                ->table('tbl_gerbang')
                                ->where('gerbang_id', $gerbangId)
                                ->first();

                            if (!$credential) {
                                Log::warning("Credential tidak ditemukan untuk gerbang $gerbangId");
                                continue;
                            }

                            // Identifikasi database tujuan unik berdasarkan host:port:database
                            $dbKey = "{$credential->host}:{$credential->port}:{$credential->database}";

                            if (in_array($dbKey, $insertedDbs)) {
                                continue; // Lewati jika sudah pernah insert ke DB ini
                            }

                            // Set koneksi dinamis mysql2
                            Config::set('database.connections.mysql2', [
                                'driver' => 'mysql',
                                'host' => $credential->host,
                                'port' => $credential->port,
                                'database' => $credential->database,
                                'username' => $credential->user,
                                'password' => $credential->pass,
                            ]);

                            // Bersihkan dan konek ulang mysql2
                            DB::purge('mysql2');
                            DB::reconnect('mysql2');

                            try {
                                // Gunakan updateOrInsert untuk hindari duplikat key
                                DB::connection('mysql2')
                                    ->table('tbl_blacklist')
                                    ->updateOrInsert(
                                        ['no_registrasi' => $blacklist->no_registrasi],
                                        [
                                            'uuid' => $blacklist->uuid,
                                            'info' => $blacklist->info,
                                            'jenis_ktp' => $blacklist->jenis_ktp,
                                            'tick' => $blacklist->tick,
                                            'penempatan_gerbang' => $blacklist->penempatan_gerbang,
                                        ]
                                    );

                                $insertedDbs[] = $dbKey; // Tandai bahwa DB ini sudah diproses

                            } catch (\Exception $e) {
                                Log::error("Gagal insert ke gerbang {$gerbangId} ({$dbKey}): {$e->getMessage()}");
                            }
                        }

                        // Tandai data sudah disinkronisasi
                        DB::connection('integrasi_bcds')->table('tbl_blacklist')
                            ->where('uuid', $blacklist->uuid)
                            ->update(['sync' => 1]);

                        $processed++;
                    }

                    if ($processed >= $maxRecords) {
                        return false;
                    }
                });

            return response()->json([
                'status' => 'success',
                'message' => "Berhasil memproses $processed data blacklist",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function whitelist_ktp($id)
    {
        try {
            DB::beginTransaction();

            // Update status whitelist
            $updated = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')
                ->where('id', $id)
                ->update(['status' => 1]);

            if ($updated) {
                $row = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')
                    ->where('id', $id)
                    ->first();

                if ($row) {
                    // Hapus dari blacklist di integrasi_bcds
                    DB::connection('integrasi_bcds')->table('tbl_blacklist')
                        ->where('no_registrasi', $row->no_registrasi)
                        ->delete();

                    // Ambil semua gerbang tujuan dari penempatan
                    $gerbangIds = explode(',', $row->penempatan_gerbang);
                    $deletedDbs = [];

                    foreach ($gerbangIds as $gerbangId) {
                        $credential = DB::connection('integrasi_bcds')->table('tbl_gerbang')
                            ->where('gerbang_id', $gerbangId)
                            ->first();

                        if (!$credential) {
                            Log::warning("Credential tidak ditemukan untuk gerbang $gerbangId");
                            continue;
                        }

                        $dbKey = "{$credential->host}:{$credential->port}:{$credential->database}";
                        if (in_array($dbKey, $deletedDbs)) {
                            continue; // Hindari hapus 2x dari DB yang sama
                        }

                        // Atur koneksi dinamis
                        Config::set('database.connections.mysql2', [
                            'driver' => 'mysql',
                            'host' => $credential->host,
                            'port' => $credential->port,
                            'database' => $credential->database,
                            'username' => $credential->user,
                            'password' => $credential->pass,
                        ]);

                        DB::purge('mysql2');
                        DB::reconnect('mysql2');

                        try {
                            DB::connection('mysql2')->table('tbl_blacklist')
                                ->where('no_registrasi', $row->no_registrasi)
                                ->delete();

                            $deletedDbs[] = $dbKey;
                        } catch (\Exception $e) {
                            Log::error("Gagal menghapus no_registrasi {$row->no_registrasi} dari DB {$dbKey}: {$e->getMessage()}");
                        }
                    }
                }
            }

            DB::commit();
            return response(['status' => 200, 'message' => "Data berhasil di-whitelist"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'status' => 500,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage(),
            ]);
        }
    }


    private function formatEndian($endian, $format = 'N')
    {
        $endian = intval($endian, 16);      // convert string to hex
        $endian = pack('L', $endian);       // pack hex to binary sting (unsinged long, machine byte order)
        $endian = unpack($format, $endian); // convert binary sting to specified endian format

        return sprintf("%'.08x", $endian[1]); // return endian as a hex string (with padding zero)
    }

    public function tambah_kartu(Request $request)
    {
        $ruas = DB::connection('integrasi_bcds')->table('tbl_ktp_ruas_kartu')->where("id", $request->ruas)->first();

        $request->validate([
            'nomor_kartu' => 'required',
            'pemilik_kartu' => 'required',
            'ruas' => 'required',
            'jenis_ktp' => 'required',
            'institusi' => 'required',
            'unit' => 'required',
            'tgl_kadaluarsa' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // nomor_kartu dari frontend cuma prefix (institusi+ruas+unit), belum
            // menjamin unik. Tambahkan suffix urut 3 digit per prefix supaya
            // no_registrasi akhir selalu unik (format: prefix + 001, 002, dst).
            $prefix = $request->nomor_kartu;
            $urutan = DB::connection('integrasi_bcds')
                ->table('tbl_penerbitan_kartu')
                ->where('no_registrasi', 'like', $prefix . '%')
                ->count() + 1;
            $noRegistrasi = $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->insert([
                'ktp_id' => '',
                'no_referensi' => $request->no_ref,
                'ruas' =>  $ruas->fisik_kartu,
                'no_registrasi' => $noRegistrasi,
                'ktp_jenis_id' => $request->jenis_ktp,
                'model_operasi' => 0,
                'tgl_terbit' => date('Y-m-d'),
                'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
                'nama' => $request->pemilik_kartu,
                'penempatan_gerbang' => '',
                'status' => 1,
            ]);

            DB::connection('integrasi_bcds')->table('tbl_log_operasional')->insert([
                'npp_no' => auth()->user()->npp_no,
                'id_jabatan' => auth()->user()->jabatan_id,
                'waktu' => date('Y-m-d H:i:s'),
                'kategori' => 2,
                'event' => 'insert',
                'keterangan' => json_encode($request->all()),
                // 'gerbang_id' => auth()->user()->gerbang_id,
            ]);

            // Commit transaction
            DB::commit();

            return response(['status' => 200, 'message' => "Data berhasil ditambahkan"]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    public function buat()
    {
        return view('admin.kartu.buatKartu');
    }

    public function getDetailData(Request $request)
    {
        $data =  DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')
            ->select('tbl_penerbitan_kartu.*', 'tbl_ruas.nama_ruas')
            ->join('tbl_ruas', 'tbl_ruas.ruas_id', '=', 'tbl_penerbitan_kartu.ruas')
            ->where('tbl_penerbitan_kartu.id', $request->id)
            ->first();

        return $data;
    }

    public function generateDataKartu(Request $request)
    {
        $nomor = $request->no_ktp;
        $ruas = $request->kode_ruas;
        $expire = $request->masa_berlaku;
        $tipe = $request->tipe_ktp;
        $uid = $request->uid_ktp;
        $id = $request->id_ktp;

        $data = $this->ktp_write($nomor, $ruas, $expire, $tipe, $uid);

        try {
            DB::beginTransaction();

            // Update data penerbitan kartu
            DB::connection("integrasi_bcds")->table("tbl_penerbitan_kartu")->where("id", $id)->update([
                'ktp_id' => $uid,
            ]);

            // Menyimpan log operasional
            DB::connection('integrasi_bcds')->table('tbl_log_operasional')->insert([
                // Uncomment and use if needed
                // 'npp_no' => auth()->user()->npp_no,
                // 'id_jabatan' => auth()->user()->jabatan_id,
                'user_id' => auth()->user()->npp_no,
                'user_tipe' => '99',
                'waktu' => now(), // Gunakan helper now() untuk mendapatkan timestamp
                'kategori' => 3,
                'event' => 'encode kartu',
                'keterangan' => json_encode($nomor), // Pastikan $nomor adalah variabel yang valid
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => "Data kartu berhasil di-generate",
                'data' => $data // Pastikan $data adalah variabel yang valid
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function updateUID(Request $request)
    {
        $uid = $request->uid;
        $no_registrasi = $request->registrasi;

        try {

            DB::beginTransaction();

            $this->updatedUID($no_registrasi, $uid);

            $data = DB::connection('integrasi_bcds')
                ->table('tbl_log_operasional')->insert([
                    // 'npp_no' => auth()->user()->npp_no,
                    // 'id_jabatan' => auth()->user()->jabatan_id,
                    'user_id' => auth()->user()->npp_no,
                    'user_tipe' => '99',
                    'waktu' => date('Y-m-d H:i:s'),
                    'kategori' => 3,
                    'event' => 'syncing uid',
                    'keterangan' => json_encode($no_registrasi . " | " . $uid),
                ]);

            DB::commit();

            return response(['status' => 200, 'message' => "Data kartu berhasil generate", 'data' => $data]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    private function updatedUID($no_registrasi, $uid)
    {
        try {
            DB::beginTransaction();

            $res = DB::connection('integrasi_bcds')
                ->table('tbl_penerbitan_kartu')
                ->where('no_registrasi', $no_registrasi)
                ->update([
                    'ktp_id' => $uid,
                    'status' => 1
                ]);

            return $res;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['status' => 500, 'message' => 'Gagal!', 'error' => $e->getMessage()]);
        }
    }

    public function baca()
    {
        return view('admin.kartu.bacaKartu');
    }

    public function perpanjang()
    {
        return view('admin.kartu.perpanjangKartu');
    }

    public function blacklist()
    {
        if (request()->ajax()) {
            $q =  DB::connection('integrasi_bcds')->table('tbl_blacklist');

            if (request()->filled('search')) {
                $searchValue = request()->search;
                $q->where(function ($query) use ($searchValue) {
                    $query->where('uuid', 'like', "%{$searchValue}%")
                        ->orWhere('no_registrasi', 'like', "%{$searchValue}%")
                        ->orWhere('info', 'like', "%{$searchValue}%")
                        ->orWhere('jenis_ktp', 'like', "%{$searchValue}%");
                });
            }

            $q->get();

            return DataTables::of($q)
                ->addColumn('tick', function ($row) {
                    return Carbon::createFromTimestamp($row->tick)->toDateTimeString();
                })
                ->addColumn('jenis', function ($row) {
                    if ($row->jenis_ktp == 1) {
                        $jenis = 'Operasional';
                    } else if ($row->jenis_ktp == 2) {
                        $jenis = 'Karyawan';
                    } else if ($row->jenis_ktp == 3) {
                        $jenis = 'Mitra';
                    } else {
                        $jenis = 'UNKNOWN';
                    }

                    return $jenis;
                })
                ->addColumn('sync', function ($row) {
                    if ($row->sync == 0) {
                        return '<span class="badge bg-warning rounded-pill">Belum Dikirim</span>';
                    } else {
                        return '<span class="badge  bg-primary rounded-pill">Sudah Dikirim</span>';
                    }
                })
                ->rawColumns(['sync'])
                ->make();
        }

        return view('admin.kartu.blacklist', [
            'judul' => 'Blacklist',
            'Columns' => [
                [
                    'title' => 'UID',
                    'data' => 'uuid',
                    'name' => 'tbl_blacklist.uuid'
                ],
                [
                    'title' => 'Nama Kartu',
                    'data' => 'info',
                    'name' => 'tbl_blacklist.info'
                ],
                [
                    'title' => 'No Kartu',
                    'data' => 'no_registrasi',
                    'name' => 'tbl_blacklist.no_registrasi',
                ],
                [
                    'title' => 'Jenis',
                    'data' => 'jenis',
                    'name' => 'jenis',
                ],
                [
                    'title' => 'Tick',
                    'data' => 'tick',
                    'name' => 'tbl_blacklist.tick',
                ],
                [
                    'title' => 'Sync',
                    'data' => 'sync',
                    'name' => 'tbl_blacklist.sync',
                ],
            ]
        ]);
    }

    private function ktp_datalen($input, $len)
    {
        return strtolower(str_pad(substr($input, 0, $len), $len, "0", STR_PAD_LEFT));
    }

    private function ktp_enc($pbk, $pvk, $clear)
    {
        $block = $this->bchexdec($clear);
        return $this->bcdechex(bcpowmod($block, $this->bchexdec($pvk), $this->bchexdec($pbk)));
    }

    private function bchexdec($hex)
    {
        if (strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, $this->bchexdec($remain)), hexdec($last));
        }
    }

    private function bcdechex($dec)
    {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);

        if ($remain == 0) {
            return dechex($last);
        } else {
            return $this->bcdechex($remain) . dechex($last);
        }
    }

    public function getDetailKTP(Request $request)
    {
        $_PUB = env('PUBLIC_KEY');

        $blok0 = $request->blok0;
        $blok1 = $request->blok1;
        $blok2 = $request->blok2;

        $datax = $this->ktp_read($_PUB, $blok0, $blok1, $blok2);
        $data['data'] = $datax;
        $ktpNama = $this->getOptionKTPnama($datax['uid']);

        if ($ktpNama) {
            $data['ktpNama'] = $ktpNama;
        } else {
            $x    = [array('nama' => 'Not Found / Data Hilang')];
            $data['ktpNama'] = $x;
        }

        return $data;
    }

    private function getOptionKTPnama($id)
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->where('ktp_id', $id)->get();

        return $data;
    }

    function ktp_dec($pbk, $cipher)
    {
        return $this->bcdechex(bcpowmod($this->bchexdec($cipher), $this->bchexdec('10001'), $this->bchexdec($pbk)));
    }

    function ktp_read($pbk, $block0, $block1, $block2)
    {
        $cipher = "{$block0}{$block1}{$block2}";
        $clear = $this->ktp_dec($pbk, $cipher);
        if (strlen($clear) != 48)  return false;
        if (substr($clear, 0, 2) != 'fe') return false;

        return array(
            'ruas' => substr($clear, 2, 4),
            'expire' => substr($clear, 6, 8),
            'tipe' => substr($clear, 14, 2),
            'nokartu' => substr($clear, 16, 16),
            'uid' => substr($clear, 32, 8),
            'crc32' => substr($clear, 40, 8),
            'packed' => $clear
        );
    }

    private function ktp_write($nomor, $ruas, $expire, $tipe, $uid)
    {

        $expiredDate = str_replace('-', '', $expire);
        $pbk        = env("PUBLIC_KEY");
        $pvk        = env("PRIVATE_KEY");
        $nomor      = $this->ktp_datalen($nomor, 16);
        $ruas       = $this->ktp_datalen($ruas, 4);
        $expire     = $this->ktp_datalen($expiredDate, 8);
        $tipe       = $this->ktp_datalen($tipe, 2);
        $uid        = $this->ktp_datalen($uid, 8);
        $data       = "fe{$ruas}{$expire}{$tipe}{$nomor}{$uid}";
        $cksum      = sprintf("%08x", crc32($data));
        $clear        = "{$data}{$cksum}";
        $cipher        = $this->ktp_datalen($this->ktp_enc($pbk, $pvk, $clear), 96);

        return array(
            substr($cipher, 0, 32),
            substr($cipher, 32, 32),
            substr($cipher, 64, 32)
        );
    }

    public function getUnit()
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_ktp_unit')->get();

        return response()->json($data);
    }

    public function getRuas()
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_ruas')->get();

        return response()->json($data);
    }

    public function getKtpOpr()
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_jenis_ktp')->get();

        return response()->json($data);
    }

    public function getInstitusi()
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_ktp_institusi')->get();

        return response()->json($data);
    }

    public function getRuasKartu()
    {
        $data = DB::connection('integrasi_bcds')->table('tbl_ktp_ruas_kartu')->get();

        return response()->json($data);
    }

    public function edit_kartu(Request $request)
    {
        $request->validate([
            'pemilik_kartu' => 'required',
            'jenis_ktp' => 'required',
        ]);

        try {
            DB::beginTransaction();

            DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->where('id', $request->id)->update([
                'ktp_jenis_id' => $request->jenis_ktp,
                'nama' => $request->pemilik_kartu,
                'status' => 1,
            ]);

            DB::connection('integrasi_bcds')->table('tbl_log_operasional')->insert([
                'npp_no' => auth()->user()->npp_no,
                'id_jabatan' => auth()->user()->jabatan_id,
                'waktu' => date('Y-m-d H:i:s'),
                'kategori' => 2,
                'event' => 'update',
                'keterangan' => json_encode($request->all()),
            ]);

            // Commit transaction
            DB::commit();

            return response(['status' => 200, 'message' => "Data berhasil diupdate"]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['status' => 500, 'message' => 'Gagal update data', 'error' => $e->getMessage()]);
        }
    }

    public function getOptionNama(Request $request, $tipe = '0')
    {
        $data = DB::connection('integrasi_bcds')
            ->table('tbl_penerbitan_kartu')
            ->select(['nama', 'id', 'no_registrasi'])
            ->where('isdeleted', 0)
            ->where('nama', 'LIKE', '%' . $request->get('q') . '%');

        if ($tipe == '0') {
            //$data->whereIn('ruas', ['a07f', 'a075', 'a077', 'A052', 'A050', 'A04F', 'A04D', 'A047', 'A045', 'A02C', 'A024'])->get();
            $data->whereIn('ruas', ['b001'])->get();
        } else if ($tipe == '1') {
            //$data->whereIn('ruas', ['a045', 'a047', 'a04d', 'a04f', '86'])->get();
            $data->whereIn('ruas', ['b001'])->get();
        } else if ($tipe == '2') {
            //$data->whereIn('ruas', ['a024', 'a02c'])->get();
            $data->whereIn('ruas', ['b001'])->get();
        } else if ($tipe == '3') {
            //$data->whereIn('ruas', ['a050', 'a052'])->get();
            $data->whereIn('ruas', ['b001'])->get();
        }

        $results = $data->get();

        return response()->json($results);
    }
}
