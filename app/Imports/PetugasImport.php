<?php

namespace App\Imports;

use App\Models\tbl_pegawai;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class PetugasImport implements ToCollection
{

    private $errors;
   
    /**
    * @param Collection $collection
    */

    public function __construct()
    {
        $this->errors = array();
    }

    public function collection(Collection $collection)
    {
        // START ROW IN INDEX 2
        // START COLUMN ROW IN INDEX 1
        // $collection[2][1]
        for ($row = 2; $row < count($collection); $row++) {
            tbl_pegawai::create([
                'npp_no' => $collection[$row][1],                   // NPP PETUGAS
                'email' => $collection[$row][2],                    // EMAIL PETUGAS
                'nama_pegawai' => $collection[$row][3],             // NAMA PETUGAS
                'password' => Hash::make($collection[$row][4]),     // PASSWORD PETUGAS = NPP_NO
                'jabatan_id' => 3                                   // JABATAN PETUGAS
            ]);
        }
    }

    public function getFailed(){
        return $this->errors;
    }
}
