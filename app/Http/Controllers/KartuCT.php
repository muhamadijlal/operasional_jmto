<?php

namespace App\Http\Controllers;

use App\Models\tbl_penerbitan_kartu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KartuCT extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $q = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu');
            // if(request()->filled('kategori_id') && request()->kategori_id != '*') {
            //     $q->where('kategori', request()->kategori_id);
            // }

            return DataTables::of($q)
            ->addColumn('jenis', function($row){
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
            ->addColumn('ruas', function($row) {

                switch ($row->ruas) {
                    case 'a045':
                        $ruas = '<span style="background-color:blue;" class="badge rounded-pill">MTN</span>';
                        break;
                    case 'a047':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">MTN</span>
                                    <span style="background-color:red;" class="badge rounded-pill">JANGER</span>
                                </div>';
                        break;
                    case 'a04d':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">MTN</span>
                                    <span style="background-color:red;" class="badge rounded-pill">BSD</span>
                                </div>';
                        break;
                    case 'a04f':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">MTN</span>
                                    <span style="background-color:red;" class="badge rounded-pill">JANGER</span>
                                    <span style="background-color:red;" class="badge rounded-pill">BSD</span>
                                </div>';
                        break;
                    case 'a050':
                        $ruas = '<span style="background-color:blue;" class="badge rounded-pill">JKC</span>';
                        break;
                    case 'a052':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">JKC</span>
                                    <span style="background-color:red;" class="badge rounded-pill">JANGER</span>
                                </div>';
                        break;
                    case 'a024':
                        $ruas = '<span style="background-color:blue;" class="badge rounded-pill">CSJ</span>';
                        break;
                    case 'a02c':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">CSJ</span>
                                    <span style="background-color:red;" class="badge rounded-pill">BSD</span>
                                </div>';
                        break;
                    case 'a075':
                        $ruas = '<span style="background-color:blue;" class="badge rounded-pill">JORR</span>';
                        break;
                    case 'a07f':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">JORR2</span>
                                    <span style="background-color:blue;" class="badge rounded-pill">JANGER</span>
                                    <span style="background-color:blue;" class="badge rounded-pill">BSD</span>
                                </div>';
                        break;
                    case 'a077':
                        $ruas = '<div class="d-flex gap-1">
                                    <span style="background-color:blue;" class="badge rounded-pill">JORR2</span>
                                    <span style="background-color:blue;" class="badge rounded-pill">JANGER</span>
                                </div>';
                        break;
                    default:
                        $ruas = '<span style="background-color:blue;" class="badge rounded-pill">Unknown</span>';
                        break;
                    }

                    return $ruas;
            })
            ->addColumn('tgl_terbit', function($row){
                $date_formatted = date('d F Y', strtotime($row->tgl_terbit));

                return $date_formatted;
            })
            ->addColumn('tgl_kadaluarsa', function($row){
                $date_formatted = date('d F Y', strtotime($row->tgl_kadaluarsa));

                return $date_formatted;
            })
            ->addColumn('no_ref', function($row){
               $no_ref =  $row->no_referensi ? $row->no_referensi : '';

                return $no_ref;
            })
            ->addColumn('status', function($row){
                switch($row->status){
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
                if($row->status == 2){
                    $btn = '
                        <div class="d-flex">
                            <a href="#" class="btn m-1 btn-success btn-sm" id="whitelist" data-id="' . $row->id . '"><i class="fa-solid fa-check"></i></a>
                        </div>
                    ';
                }else{
                    $btn = '
                        <div class="d-flex">
                            <a href="#" class="btn m-1 btn-danger btn-sm" id="blacklist" data-id="' . $row->id . '"><i class="fa-solid fa-ban"></i></a>
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

    public function blacklist_ktp($id){
        try{
            DB::beginTransaction();

            $updated =  DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->where('id', $id)->update([
                'status' => 2
            ]);

            if($updated) {
                $row = DB::table('tbl_penerbitan_kartu')
                        ->where('id', $id)
                        ->first();
    
                if ($row) {
                    $uuid = hexdec($this->formatEndian($row->ktp_id));
                    $currentTimestamp = strtotime(now());
                
                    DB::connection('integrasi_bcds')->table('tbl_blacklist')->upsert(
                        [
                            [
                                'uuid' => $uuid,
                                'no_registrasi' => $row->no_registrasi,
                                'info' => $row->nama,
                                'jenis_ktp' => $row->ktp_jenis_id,
                                'tick' => $currentTimestamp,
                                'penempatan_gerbang' => $row->penempatan_gerbang,
                            ]
                        ],
                        ['uuid'],
                        ['no_registrasi', 'info', 'jenis_ktp', 'tick', 'penempatan_gerbang']
                    );
                }                    
            }

            DB::commit();

            return response(['status' => 200, 'message' => "Data berhasil di blacklist"]);
        }catch (\Exception $e) {
            DB::rollBack();
        
            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    public function whitelist_ktp($id){
        try{
            DB::beginTransaction();

            $updated =  DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->where('id', $id)->update([
                'status' => 1
            ]);
    
            if($updated) {
    
                $row =  DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')
                            ->where('id', $id)
                            ->first();
    
                if ($row) {
                    DB::connection('integrasi_bcds')->table('tbl_blacklist')->where('no_registrasi', $row->no_registrasi)->delete();
                }                    
            }

            DB::commit();
    
            return response(['status' => 200, 'message' => "Data berhasil di whitelist"]);
        }catch (\Exception $e) {
            DB::rollBack();
        
            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    private function formatEndian($endian, $format = 'N') {
        $endian = intval($endian, 16);      // convert string to hex
        $endian = pack('L', $endian);       // pack hex to binary sting (unsinged long, machine byte order)
        $endian = unpack($format, $endian); // convert binary sting to specified endian format
    
        return sprintf("%'.08x", $endian[1]); // return endian as a hex string (with padding zero)
    }

    public function tambah_kartu(Request $request) {
        $request->validate([
            'nomor_kartu' => 'required',
            'pemilik_kartu' => 'required',
            'ruas' => 'required',
            'jenis_ktp' => 'required',
            'institusi' => 'required',
            'unit' => 'required',
            'tgl_kadaluarsa' => 'required',
        ]);

        try{
            DB::beginTransaction();


            DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->insert([
                'ktp_id' => '',
                'no_registrasi' => $request->nomor_kartu,
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
        }catch (\Exception $e) {
            DB::rollBack();
        
            return response(['status' => 500, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()]);
        }
    }

    public function buat(){
        return view('admin.kartu.buatkartu');
    }

    public function getDetailData(Request $request){
        $data =  DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')
                    ->join('tbl_ktp_ruas', 'tbl_ktp_ruas.ruas_id', '=', 'tbl_penerbitan_kartu.ruas')
                    ->select('tbl_penerbitan_kartu.*','tbl_ktp_ruas.nama_ruas')
                    ->where('tbl_penerbitan_kartu.id', $request->id)
                    ->first();

        return $data;
    }

    public function generateDataKartu(Request $request){
        $nomor = $request->no_ktp;
        $ruas = $request->kode_ruas;
        $expire = $request->masa_berlaku;
        $tipe = $request->tipe_ktp;
        $uid = $request->uid_ktp;

        $data = $this->ktp_write($nomor, $ruas, $expire, $tipe, $uid);

        DB::connection('integrasi_bcds')->table('tbl_log_operasional')->insert([
            // 'npp_no' => auth()->user()->npp_no,
            // 'id_jabatan' => auth()->user()->jabatan_id,
            'user_id' => auth()->user()->npp_no,
            'user_tipe' => '99',
            'waktu' => date('Y-m-d H:i:s'),
            'kategori' => 3,
            'event' => 'encode kartu',
            'keterangan' => json_encode($nomor),
        ]);

        return response(['status' => 200, 'message' => "Data kartu berhasil generate", 'data' => $data]);
    }

    public function updateUID(Request $request) {
        $uid = $request->uid;
        $no_registrasi = $request->registrasi;

        try {

            DB::beginTransaction();

            $this->updatedUID($no_registrasi, $uid);

            $data = DB::connection('integrasi_bcds')
                ->table('tbl_log_operasional')->create([
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

        }catch (\Exception $e) {
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
                        
        }catch (\Exception $e) {
            DB::rollBack();
        
            return response(['status' => 500, 'message' => 'Gagal!', 'error' => $e->getMessage()]);
        }
    }

    public function simpan(Request $request){
        return 'oke';
    }

    public function baca(){
        return view('admin.kartu.bacakartu');
    }

    public function perpanjang(){
        return view('admin.kartu.perpanjangkartu');
    }

    public function blacklist(){
        if (request()->ajax()) {

            $q =  DB::connection('integrasi_bcds')->table('tbl_blacklist')->get();

            return DataTables::of($q)
            ->addColumn('jenis', function($row){

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
            ]
        ]);
    }

    private function ktp_datalen($input,$len){
        return strtolower(str_pad(substr($input,0,$len), $len, "0", STR_PAD_LEFT));
    }

    private function ktp_enc($pbk, $pvk, $clear){
        $block = $this->bchexdec($clear);
        return $this->bcdechex(bcpowmod($block, $this->bchexdec($pvk), $this->bchexdec($pbk)));
    }

    private function bchexdec($hex) {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, $this->bchexdec($remain)), hexdec($last));
        }
    }

    private function bcdechex($dec) {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);
    
        if($remain == 0) {
            return dechex($last);
        } else {
            return $this->bcdechex($remain).dechex($last);
        }
    }

    public function getDetailKTP(Request $request) {
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
			$x	= [array('nama' => 'Not Found / Data Hilang')];
			$data['ktpNama'] = $x;
		}

		return $data;
    }

    private function getOptionKTPnama($id)
	{
        $data = DB::connection('integrasi_bcds')->table('tbl_penerbitan_kartu')->where('ktp_id', $id)->get();

        return $data;
	}

    function ktp_dec($pbk, $cipher){
        return $this->bcdechex(bcpowmod($this->bchexdec($cipher), $this->bchexdec('10001'),$this->bchexdec($pbk)));
    }

    function ktp_read($pbk, $block0, $block1, $block2){
        $cipher="{$block0}{$block1}{$block2}";
        $clear = $this->ktp_dec($pbk, $cipher);
        if (strlen($clear)!=48)  return false;
        if (substr($clear,0,2)!='fe') return false;

        return array(
            'ruas'=>substr($clear,2,4),
            'expire'=>substr($clear,6,8),
            'tipe'=>substr($clear,14,2),
            'nokartu'=>substr($clear,16,16),
            'uid'=>substr($clear,32,8),
            'crc32'=>substr($clear,40,8),
            'packed'=>$clear
        );
    }

    private function ktp_write($nomor, $ruas, $expire, $tipe, $uid){
        $pbk        = env("PUBLIC_KEY");
        $pvk        = env("PRIVATE_KEY");
        $nomor      = $this->ktp_datalen($nomor,16);
        $ruas       = $this->ktp_datalen($ruas,4);
        $expire     = $this->ktp_datalen($expire,8);
        $tipe       = $this->ktp_datalen($tipe,2);
        $uid        = $this->ktp_datalen($uid,8);
        $data       = "fe{$ruas}{$expire}{$tipe}{$nomor}{$uid}";
        $cksum      = sprintf("%08x",crc32($data));
        $clear		= "{$data}{$cksum}";
        $cipher		= $this->ktp_datalen($this->ktp_enc($pbk, $pvk, $clear),96);
        
        return array(
            substr($cipher, 0, 32),
            substr($cipher, 32, 32),
            substr($cipher, 64, 32)
        );
    }
}
