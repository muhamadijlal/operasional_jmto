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

                try {
                    $modelAsalGerbang = DB::connection('mysql')->table('tbl_gerbang')->where('gerbang_nama', $asal_gerbang)->first();

                    if (!$modelAsalGerbang) {
                        throw new ModelNotFoundException("Data dengan nama gerbang '{$asal_gerbang}' tidak ditemukan.");
                    }
                } catch (ModelNotFoundException $e) {
                    // Tangani pengecualian sesuai kebutuhan, misalnya:
                    return response()->json(['error' => $e->getMessage()], 404);
                } catch (QueryException $e) {
                    // Tangani pengecualian query lainnya jika diperlukan
                    return response()->json(['error' => 'Terjadi kesalahan pada query.'], 500);
                }   

                if ($modelAsalGerbang) {
                    // Config::set('database.connections.mysql2.host', $this->gerbang->host);
                    Config::set('database.connections.mysql2.port', $this->gerbang->port);
                    Config::set('database.connections.mysql2.database', $this->gerbang->database);
                    Config::set('database.connections.mysql2.username', $this->gerbang->user);
                    Config::set('database.connections.mysql2.password', $this->gerbang->pass);
                    
                    $dataDB = DB::connection('mysql2')->table('tbl_tarif_exit')->insert([
                        'ruas_id' => $this->gerbang->ruas_id,
                        'gerbang_id' => $this->gerbang->gerbang_id,
                        'asal_gerbang' => $modelAsalGerbang->gerbang_id,
                        'jenis' => $modelAsalGerbang->jenis,
                        'gol1' => $gol1,
                        'gol1_d' => '[' . implode(',', $gol1_d) . ']',
                        'gol2' => $gol2,
                        'gol2_d' => '[' . implode(',', $gol2_d) . ']',
                        'gol3' => $gol3,
                        'gol3_d' => '[' . implode(',', $gol3_d) . ']',
                        'gol4' => $gol4,
                        'gol4_d' => '[' . implode(',', $gol4_d) . ']',
                        'gol5' => $gol5,
                        'gol5_d' => '[' . implode(',', $gol5_d) . ']',
                        'tgl_berlaku' =>  $this->request->waktu,
                        'id_dasar_tarif' => $this->request->dasartarifmodal,
                        'aktif' => 1,
                        'tarif_inv' => '[' . implode(',', str_replace('"', '', $investors)) . ']',
                        save();
                    ]);

                } else {
                    $this->failed[] = $asal_gerbang;
                }
            }
        }
    }

    public function getFailed()
    {
        return $this->failed;
    }
}
