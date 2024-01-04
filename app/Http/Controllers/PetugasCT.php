<?php

namespace App\Http\Controllers;

use App\Models\tbl_pegawai;
use Illuminate\Http\Request;

class PetugasCT extends Controller
{
    //

    public function BuatPetugas()
    {
        return view(
            'admin.petugas.buatPetugas'
        );
    }

    public function BuatPetugasTambah(Request $request)
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
}
