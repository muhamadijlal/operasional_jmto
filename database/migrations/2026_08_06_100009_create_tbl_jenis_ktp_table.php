<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql. Referensi dropdown jenis KTP (Operasional/Karyawan/Mitra).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_jenis_ktp', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->integer('jenis_ktp_id')->primary();
            $table->string('jenis_ktp', 11);
            $table->string('keterangan', 23)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_jenis_ktp');
    }
};
