<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: integrasi_bcds (DB integrasi nasional, dipakai bersama semua ruas).
 * Skema berbeda dari mysql.tbl_ruas (ruas_id varchar di sini, bukan int).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('integrasi_bcds')->create('tbl_ruas', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('ruas_id', 4)->primary();
            $table->string('nama_ruas', 200);
            $table->string('bujt', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_ruas');
    }
};
