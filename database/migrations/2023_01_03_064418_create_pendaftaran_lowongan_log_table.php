<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('pendaftaran_lowongan_log', function (Blueprint $table) {
            $table->engine = env('DB_STORAGE_ENGINE', 'InnoDB');
            $table->charset = env('DB_CHARSET', 'utf8mb4');
            $table->collation = env('DB_COLLATION', 'utf8mb4_general_ci');
            $table->id('nomor');
            $table->integer('id_lowongan');
            $table->integer('id_pelamar');
            $table->char('kode_pendaftaran', 20);
            $table->enum('verifikasi', ['Sudah', 'Belum']);
            $table->enum('status_seleksi', ['Lulus', 'Tidak', 'Belum tuntas mengikuti seleksi']);
            $table->enum('event', ['insert', 'update', 'delete']);
            $table->text('keterangan');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('pendaftaran_lowongan_log');
    }
};
