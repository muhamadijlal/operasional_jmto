<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Koneksi: mysql2 (DB lokal gerbang). `view_tarif` adalah VIEW SQL yang sudah
 * ada di database gerbang produksi, dipakai read-only oleh
 * ManajemenTarifCT::exportClose/viewClose. Definisi aslinya tidak ditemukan
 * di kode aplikasi (hanya di-query, tidak dibuat) — SELECT di bawah adalah
 * REKONSTRUKSI berdasarkan kolom yang di-join/select di controller (identik
 * dengan kolom tbl_tarif_exit, difilter aktif=1). Verifikasi ke definisi VIEW
 * asli di server sebelum menjalankan migration ini di lingkungan yang belum
 * punya `view_tarif`.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mysql2')->statement(<<<SQL
            CREATE VIEW view_tarif AS
            SELECT
                id,
                gerbang_id,
                asal_gerbang,
                jenis,
                gol1, gol1_d,
                gol2, gol2_d,
                gol3, gol3_d,
                gol4, gol4_d,
                gol5, gol5_d,
                tgl_berlaku,
                id_dasar_tarif,
                tarif_inv
            FROM tbl_tarif_exit
            WHERE aktif = 1
        SQL);
    }

    public function down(): void
    {
        DB::connection('mysql2')->statement('DROP VIEW IF EXISTS view_tarif');
    }
};
