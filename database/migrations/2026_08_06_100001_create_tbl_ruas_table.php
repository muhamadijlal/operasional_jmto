<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql (DB pusat ruas ini). Skema direkonstruksi dari SHOW CREATE TABLE
 * database jpb_bcds — sesuaikan bila skema di server tujuan berbeda.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_ruas', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->integer('ruas_id')->primary();
            $table->string('ruas_nama', 200);
            $table->string('ruas_id_ktp')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_ruas');
    }
};
