<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: integrasi_bcds (DB integrasi nasional). Blacklist master, sumber
 * sinkronisasi ke mysql2.tbl_blacklist per gerbang (KartuCT::sync_blacklist).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('integrasi_bcds')->create('tbl_blacklist', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('uuid', 16)->nullable()->default('')->unique();
            $table->string('no_registrasi')->primary();
            $table->string('info', 128)->nullable()->default('');
            $table->smallInteger('jenis_ktp')->nullable();
            $table->bigInteger('tick')->default(0);
            $table->string('penempatan_gerbang')->nullable();
            $table->integer('sync')->default(0);
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_blacklist');
    }
};
