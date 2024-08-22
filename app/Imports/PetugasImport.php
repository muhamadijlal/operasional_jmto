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
   
    /**
    * @param Collection $collection
    */

    public function __construct($request)
    {
        $this->errors = array();
        $this->gerbang_id = $request->gerbang_id;
    }

    public function collection(Collection $collection)
    {
        // START ROW IN INDEX 2
        // START COLUMN ROW IN INDEX 1
        // $collection[2][1]
        for ($row = 2; $row < count($collection) - 1; $row++) {
            $jabatan_id = $this->getJabatanId($collection[$row][2]);

            tbl_pegawai::create([
                'npp_no' => $collection[$row][1],                   // NPP PETUGAS
                'jabatan_id' => $jabatan_id,                        // JABATAN PETUGAS
                'nama_pegawai' => $collection[$row][3],             // NAMA PETUGAS
                'gerbang_id' => $this->gerbang_id,                  // GERBANG ID
                'password' => Hash::make($collection[$row][1]),     // PASSWORD PETUGAS = NPP_NO
            ]);
        }
    }

    public function getFailed(){
        return $this->errors;
    }

    private function getJabatanId($jabatan){
        $jabatan_id = '';
        $jabatan = strtolower($jabatan);

        switch($jabatan) {
            case 'kbt':
                $jabatan_id = 1;
            case 'kspt':
                $jabatan_id = 2;
            case 'plt':
                $jabatan_id = 3;
            case 'teknisi':
                $jabatan_id = 4;
            default:
                break;
        }

        return $jabatan_id;
    }
}
