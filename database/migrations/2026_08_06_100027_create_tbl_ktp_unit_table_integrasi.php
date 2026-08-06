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
        Schema::connection('integrasi_bcds')->create('tbl_ktp_unit', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('id', 2)->primary();
            $table->string('unit')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_ktp_unit');
    }
};
