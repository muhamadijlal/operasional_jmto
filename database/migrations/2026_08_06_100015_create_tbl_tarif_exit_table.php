<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql2 (DB lokal gerbang). Tarif exit system, per pasangan
 * gerbang asal -> tujuan, per golongan (1-5).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql2')->create('tbl_tarif_exit', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->bigIncrements('id');
            $table->string('gerbang_id', 2)->nullable()->index();
            $table->string('asal_gerbang', 2)->nullable();
            $table->enum('jenis', ['khl', 'ags', 'normal'])->nullable();
            $table->integer('gol1');
            $table->text('gol1_d');
            $table->integer('gol2');
            $table->text('gol2_d');
            $table->integer('gol3');
            $table->text('gol3_d');
            $table->integer('gol4');
            $table->text('gol4_d');
            $table->integer('gol5');
            $table->text('gol5_d');
            $table->dateTime('tgl_berlaku')->nullable();
            $table->integer('id_dasar_tarif')->nullable();
            $table->boolean('aktif')->nullable();
            $table->string('tarif_inv', 128)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('tbl_tarif_exit');
    }
};
