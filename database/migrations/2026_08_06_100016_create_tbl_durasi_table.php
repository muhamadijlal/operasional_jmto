<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql2 (DB lokal gerbang). Durasi tempuh gerbang asal -> tujuan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql2')->create('tbl_durasi', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->string('gerbang_id', 2);
            $table->string('asal_gerbang', 2);
            $table->integer('durasi')->default(0);
            $table->primary(['gerbang_id', 'asal_gerbang']);
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('tbl_durasi');
    }
};
