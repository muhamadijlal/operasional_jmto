<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: integrasi_bcds (DB integrasi nasional).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('integrasi_bcds')->create('tbl_jenis_ktp', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->integer('jenis_ktp_id')->primary();
            $table->string('jenis_ktp', 11);
            $table->string('keterangan', 23)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_jenis_ktp');
    }
};
