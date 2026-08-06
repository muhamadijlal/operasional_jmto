<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Koneksi: mysql (audit log pusat ruas ini).
 * kategori: 1 Petugas, 2 Tarif, 3 Kartu Dinas, 4 Kartu Paspull, 5 Blacklist.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('tbl_log_operasional', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('id');
            $table->string('npp_no', 7);
            $table->integer('id_jabatan')->nullable();
            $table->dateTime('waktu')->nullable();
            $table->integer('kategori')->nullable()->comment('1 Petugas, 2 Tarif, 3 Kartu Dinas, 4, Kartu Paspull, 5 Blacklist');
            $table->string('event', 100)->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('gerbang_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tbl_log_operasional');
    }
};
