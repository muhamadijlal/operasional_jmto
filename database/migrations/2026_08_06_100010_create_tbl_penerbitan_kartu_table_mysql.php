<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql. Salinan lokal tabel penerbitan kartu (dipakai oleh
 * Select2CT::getOptionNama). Skema identik dengan integrasi_bcds.tbl_penerbitan_kartu
 * (lihat 2026_08_06_100020_create_tbl_penerbitan_kartu_table_integrasi.php).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_penerbitan_kartu', function (Blueprint $table) {
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
        Schema::connection('mysql')->dropIfExists('tbl_penerbitan_kartu');
    }
};
