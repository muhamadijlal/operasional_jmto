<?php

namespace App\Http\Controllers;

use App\Models\tbl_pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Select2CT extends Controller
{
    public function getGerbang(Request $request)
    {
        $data = DB::connection('mysql')
                ->table('tbl_gerbang')
                ->whereRaw("(gerbang_nama LIKE '%" . $request->get('q') . "%')")
                ->where('status', 1)
                ->orderBy('gerbang_nama', 'asc')
                ->get();

        return response()->json($data);
    }

    public function getGerbangOpen()
    {
        $data = DB::connection('mysql')
                ->table('tbl_gerbang')
                ->where('status', '1')
                ->whereIn('jenis_gerbang', ['0', '4'])
                ->get();

        return response()->json($data);
    }

    public function getGerbangExit()
    {
        $data = DB::connection('mysql')
                ->table('tbl_gerbang')
                ->where('status', '1')
                ->whereIn('jenis_gerbang', ['1', '3'])
                ->get();

        return response()->json($data);
    }

    public function getDasarTarif(Request $request)
    {
        $selectedGerbang = $request->input('gerbang');
        $gerbang = DB::connection('mysql')
                    ->table('tbl_gerbang')
                    ->where('gerbang_id', $selectedGerbang)->first();

        Config::set('database.connections.mysql2.host', $gerbang->host);
        Config::set('database.connections.mysql2.port', $gerbang->port);
        Config::set('database.connections.mysql2.database', $gerbang->database);
        Config::set('database.connections.mysql2.username', $gerbang->user);
        Config::set('database.connections.mysql2.password', $gerbang->pass);

        $data = DB::connection('mysql2')
                ->table('tbl_dasar_tarif')
                ->get();

        return response()->json($data);
    }

    public function getGerbangAjax($id)
    {

        $data = DB::connection('mysql')
                ->table('tbl_gerbang')
                ->where('gerbang_id', '!=', $id)
                ->get();

        return response()->json($data);
    }

    public function getNamaKspt()
    {
        $data = DB::connection('mysql')
                    ->table('tbl_pegawai')
                    ->where('jabatan_id', 2)
                    ->where('activated', 1)
                    ->get();

        return response()->json($data);
    }

    public function getNamaPersonil(Request $request)
    {   
        switch($request->kode)
		{
			case 1 :
				$jabatan_id = 2;
			break;
			case 2 :
				$jabatan_id = 3;
			break;
			case 3 :
				$jabatan_id = 4;
			break;
		}

        $data = DB::connection('mysql')
                ->table('tbl_pegawai')
                ->where('activated', 1)->get();

        if ($request->gerbang_id && $jabatan_id){
            $data = DB::connection('mysql')
                    ->table('tbl_pegawai')
                    ->where('activated', 1)
                    ->where('gerbang_id', $request->gerbang_id)
                    ->where('jabatan_id', $jabatan_id)
                    ->get();
        }
        
        return response()->json($data);
    }

    public function getJabatan()
    {
        $data = DB::connection('mysql')->table('tbl_jabatan')->get();
        return response()->json($data);
    }

    public function getRuasKartu()
    {
        $data = DB::connection('mysql')->table('tbl_ktp_ruas_kartu')->get();
        
        return response()->json($data);
    }

    public function getInstitusi()
    {
        $data = DB::connection('mysql')->table('tbl_ktp_institusi')->get();
        
        return response()->json($data);
    }

    public function getUnit()
    {
        $data = DB::connection('mysql')->table('tbl_ktp_unit')->get();
        
        return response()->json($data);
    }

    public function getKtpOpr()
    {
        $data = DB::connection('mysql')->table('tbl_jenis_ktp')->get();
        
        return response()->json($data);
    }

    public function getOptionNama($tipe = '0')
    {
        $data = DB::connection('mysql')->table('tbl_penerbitan_kartu')->where('isdeleted', 0);

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
        
        return $results;
    }

    public function getRuas() {
        $data = DB::connection('mysql')->table('tbl_ruas')->get();

        return $data;
    }
}
