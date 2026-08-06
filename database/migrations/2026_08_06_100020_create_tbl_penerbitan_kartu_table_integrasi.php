<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: integrasi_bcds (DB integrasi nasional). Master data penerbitan
 * kartu lintas-ruas, dipakai oleh KartuCT.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('integrasi_bcds')->create('tbl_penerbitan_kartu', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('id');
            $table->string('ktp_id', 10);
            $table->string('no_registrasi', 22);
            $table->string('no_referensi')->nullable();
            $table->integer('ktp_jenis_id');
            $table->integer('model_operasi');
            $table->date('tgl_terbit');
            $table->date('tgl_kadaluarsa');
            $table->string('nama', 32);
            $table->string('ruas', 4)->nullable();
            $table->string('penempatan_gerbang')->nullable();
            $table->smallInteger('isdeleted')->default(0);
            $table->smallInteger('status')->default(1)->comment('1 = aktif, 2 = blacklist');
        });
    }

    public function down(): void
    {
        Schema::connection('integrasi_bcds')->dropIfExists('tbl_penerbitan_kartu');
    }
};
