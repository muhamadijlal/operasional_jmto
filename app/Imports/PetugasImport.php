<?php

namespace App\Imports;

use App\Models\tbl_pegawai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class PetugasImport implements ToCollection
{

    private $errors;
    private $gerbang_id;
   

    public function __construct($request)
    {
        $this->errors = array();
        $this->gerbang_id = $request->gerbang_id;
    }

    public function collection(Collection $rows)
    {
        for ($i = 1; $i < count($rows); $i++) {
            $jabatan_id = $this->getJabatanId($rows[$i][1]);

            tbl_pegawai::create([
                'npp_no' => $rows[$i][0],                 // NPP PETUGAS
                'jabatan_id' => $jabatan_id,              // JABATAN PETUGAS
                'nama_pegawai' => $rows[$i][2],           // NAMA PETUGAS
                'gerbang_id' => $this->gerbang_id,        // GERBANG ID
                'password' => $rows[$i][1],               // PASSWORD PETUGAS = NPP_NO
            ]);
        }
    }

    public function getFailed(){
        return $this->errors;
    }

    private function getJabatanId($jabatan){
        $jabatan_id = '';
        $jabatan = strtolower($jabatan);

        if($jabatan == 'kbt'){
            $jabatan_id = 1;
        }else if($jabatan == 'kspt'){
            $jabatan_id = 2;
        }else if($jabatan == 'plt') {
            $jabatan_id = 3;
        }else {
            $jabatan_id = 4;
        }

        return $jabatan_id;
    }
}
