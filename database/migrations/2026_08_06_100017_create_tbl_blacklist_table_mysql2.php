<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql2 (DB lokal gerbang). Target sinkronisasi dari
 * integrasi_bcds.tbl_blacklist (lihat KartuCT::sync_blacklist/whitelist_ktp).
 *
 * CATATAN: tidak ada DB gerbang lokal yang tersedia untuk introspeksi saat
 * migration ini dibuat, jadi skema disamakan dengan integrasi_bcds.tbl_blacklist
 * (kolom yang sama dipakai di updateOrInsert saat sync) — verifikasi ke skema
 * DB gerbang asli sebelum menjalankan migration ini di lingkungan tersebut.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql2')->create('tbl_blacklist', function (Blueprint $table) {
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
        Schema::connection('mysql2')->dropIfExists('tbl_blacklist');
    }
};
