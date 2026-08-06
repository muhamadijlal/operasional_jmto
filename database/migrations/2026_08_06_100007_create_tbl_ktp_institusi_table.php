<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql. Referensi dropdown institusi pemegang kartu.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_ktp_institusi', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('id', 2)->primary();
            $table->string('institusi')->nullable();
            $table->string('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_ktp_institusi');
    }
};
