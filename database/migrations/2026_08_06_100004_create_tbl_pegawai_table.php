<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql (pegawai pusat ruas ini). Dipakai juga sebagai tabel Auth
 * (guard 'web' -> App\Models\User, primary key npp_no).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_pegawai', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('npp_no', 7)->primary();
            $table->string('nama_pegawai', 50);
            $table->integer('jabatan_id')->index();
            $table->string('password');
            $table->string('gerbang_id', 5)->nullable();
            $table->string('kode_tugas', 3)->nullable();
            $table->integer('kode_kelompok_tugas')->nullable();
            $table->integer('no_idx_tugas')->nullable();
            $table->integer('activated')->default(1);
            $table->string('in_gerbang', 100)->nullable();
            $table->string('penempatan_gerbang')->nullable();
            $table->smallInteger('isdeleted')->default(0);
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_pegawai');
    }
};
