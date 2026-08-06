<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql2 (DB lokal gerbang). Tarif open system per golongan (1-5).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql2')->create('tbl_tarif_open', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->bigIncrements('id');
            $table->string('ruas', 3)->nullable();
            $table->string('gerbang_id', 2)->nullable()->index();
            $table->integer('gol1');
            $table->string('gol1_d', 128);
            $table->integer('gol2');
            $table->string('gol2_d', 128);
            $table->integer('gol3');
            $table->string('gol3_d', 128);
            $table->integer('gol4');
            $table->string('gol4_d', 128);
            $table->integer('gol5');
            $table->string('gol5_d', 128);
            $table->dateTime('tgl_berlaku')->nullable();
            $table->integer('id_dasar_tarif')->nullable();
            $table->boolean('aktif')->nullable();
            $table->string('tarif_inv', 128)->nullable();
            $table->string('bagi_hasil', 128)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('tbl_tarif_open');
    }
};
