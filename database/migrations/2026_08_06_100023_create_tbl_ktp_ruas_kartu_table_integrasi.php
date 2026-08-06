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
        Schema::connection('integrasi_bcds')->create('tbl_ktp_ruas_kartu', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('id', 2)->primary();
            $table->string('ruas')->nullable();
            $table->string('fisik_kartu')->nullable();
            $table->string('user_tipe', 20)->nullable();
            $table->string('no_kartu')->nullable();
            $table->smallInteger('isdeleted')->default(0);
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_ktp_ruas_kartu');
    }
};
