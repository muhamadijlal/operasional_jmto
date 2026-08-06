<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql2 (DB lokal gerbang).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql2')->create('tbl_dasar_tarif', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('id_dasar_tarif');
            $table->string('versi_tarif', 32)->nullable();
            $table->string('dasar_tarif', 50)->nullable();
            $table->date('mulai_berlaku')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('tbl_dasar_tarif');
    }
};
