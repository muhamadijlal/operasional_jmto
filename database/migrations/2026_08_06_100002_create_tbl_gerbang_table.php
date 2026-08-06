<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql (DB pusat ruas ini). Berisi juga kredensial koneksi mysql2
 * dinamis (host/port/database/user/pass) per gerbang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_gerbang', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('gerbang_id', 2)->primary();
            $table->string('ruas_id', 3)->nullable();
            $table->string('gerbang_nama', 20)->nullable();
            $table->string('singkatan', 4)->nullable();
            $table->string('ip_pccs', 128)->nullable();
            $table->string('asal_gerbang', 2)->default('0');
            $table->string('host', 15)->nullable();
            $table->string('port', 10)->nullable();
            $table->string('user', 128)->nullable();
            $table->string('pass', 128)->nullable();
            $table->string('database', 128)->nullable();
            $table->string('gerbang_status', 128)->nullable();
            $table->string('ip_pcs')->nullable();
            $table->string('gerbang_short', 10)->nullable();
            $table->integer('status')->default(0);
            $table->string('jenis_gerbang', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_gerbang');
    }
};
