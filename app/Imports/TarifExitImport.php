<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TarifExitImport implements ToCollection
{
    private $gerbang;
    private $request;

    public function __construct($gerbang, $request)
    {
        $this->gerbang = $gerbang;
        $this->request = $request;
        $this->failed = [];
    }


    public function collection(Collection $rows)
    {

        $investors = [];

        for ($i = 0; $i < count($rows); $i++) {
            if ($i == 0) {
                for ($b = 0; $b < count($rows[$i]); $b++) {
                    if ($rows[$i][$b] != 'Asal Gerbang' && $rows[$i][$b] != 'Denda' && $rows[$i][$b] != null && $rows[$i][$b] != 'Total') {
                        $investors[] = $rows[$i][$b];
                    }
                }
            }
            if ($i >= 2) {
                $asal_gerbang = strtolower($rows[$i][0]);
                $jenis = $rows[$i][1];

                $kelipatanGetGol = 1;
                $kelipatanInv = 0;

                $gol1_d = [];
                $gol2_d = [];
                $gol3_d = [];
                $gol4_d = [];
                $gol5_d = [];


                for ($j = 2; $j < count($rows[$i]); $j++) {
                    if ($kelipatanInv < count($investors)) {
                        if ($kelipatanGetGol == 1) {
                            $gol1_d[] = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 2) {
                            $gol2_d[] = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 3) {
                            $gol3_d[] = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 4) {
                            $gol4_d[] = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 5) {
                            $gol5_d[] = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol = 1;
                            $kelipatanInv++;
                        }
                    } elseif ($kelipatanInv == count($investors)) {
                        if ($kelipatanGetGol == 1) {
                            $gol1 = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 2) {
                            $gol2 = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 3) {
                            $gol3 = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 4) {
                            $gol4 = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol++;
                        } elseif ($kelipatanGetGol == 5) {
                            $gol5 = ($rows[$i][$j] == '' || $rows[$i][$j] == null) ? 0 : $rows[$i][$j];
                            $kelipatanGetGol = 1;
                            $kelipatanInv++;
                        }
                    }
                }

                $modelAsalGerbang = tbl_gerbang::where('gerbang_nama', $asal_gerbang)->first();

                if ($modelAsalGerbang) {
                    Config::set('database.default', 'mysql2'); // Ganti 'mysql2' dengan nama koneksi yang sesuai
                    Config::set('database.connections.mysql2.host', $this->gerbang->host);
                    Config::set('database.connections.mysql2.port', $this->gerbang->port);
                    Config::set('database.connections.mysql2.database', $this->gerbang->database);
                    Config::set('database.connections.mysql2.username', $this->gerbang->user);
                    Config::set('database.connections.mysql2.password', $this->gerbang->pass);

                    $model = new tbl_tarif_exit();
                    $model->ruas_id = $this->gerbang->ruas_id;
                    $model->gerbang_id = $this->gerbang->gerbang_id;
                    $model->asal_gerbang =  $modelAsalGerbang->gerbang_id;
                    $model->jenis = $jenis;
                    $model->gol1 = $gol1;
                    $model->gol1_d =  '[' . implode(',', $gol1_d) . ']';
                    $model->gol2 = $gol2;
                    $model->gol2_d =  '[' . implode(',', $gol2_d) . ']';
                    $model->gol3 = $gol3;
                    $model->gol3_d =  '[' . implode(',', $gol3_d) . ']';
                    $model->gol4 = $gol4;
                    $model->gol4_d =  '[' . implode(',', $gol4_d) . ']';
                    $model->gol5 = $gol5;
                    $model->gol5_d =  '[' . implode(',', $gol5_d) . ']';

                    $model->tgl_berlaku = $this->request->waktu;
                    $model->id_dasar_tarif = $this->request->dasartarifmodal;
                    $model->aktif = 1;
                    $model->tarif_inv = '[' . implode(',', str_replace('"', '', $investors)) . ']';
                    $model->save();
                }
            }
        }
    }

    public function getFailed()
    {
        return $this->failed;
    }
}
