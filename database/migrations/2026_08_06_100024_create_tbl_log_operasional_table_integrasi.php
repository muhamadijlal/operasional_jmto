<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: integrasi_bcds (DB integrasi nasional). Audit log modul kartu.
 * kategori: 1 Auth, 2 Penerbitan Kartu, 3 Buat Kartu, 4 Blacklist.
 * Skema berbeda dari mysql.tbl_log_operasional (kolom user_id/user_tipe,
 * npp_no bertipe varbinary).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('integrasi_bcds')->create('tbl_log_operasional', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('id');
            $table->string('user_id', 7)->default('0');
            $table->integer('user_tipe')->nullable();
            $table->dateTime('waktu')->nullable();
            $table->integer('kategori')->nullable()->comment('1 Auth 2 Penerbitan Kartu, 3 Buat Kartu, 4 Blacklist');
            $table->string('event', 100)->nullable();
            $table->string('keterangan')->nullable();
            $table->string('id_jabatan', 10)->nullable();
        });

        // Blueprint tidak punya tipe varbinary bawaan; tambahkan lewat raw SQL.
        DB::connection('integrasi_bcds')->statement(
            'ALTER TABLE tbl_log_operasional ADD COLUMN npp_no VARBINARY(10) NULL AFTER keterangan'
        );
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_log_operasional');
    }
};
