<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dokumen_pengguna', function (Blueprint $table) {
      $table->engine = env('DB_STORAGE_ENGINE', 'InnoDB');
      $table->charset = env('DB_CHARSET', 'utf8mb4');
      $table->collation = env('DB_COLLATION', 'utf8mb4_general_ci');
      $table->integer('id_dokumen_pengguna', true);
      $table->integer('id_pelamar');
      $table->char('id_jenis_dokumen', 7);
      $table->string('nama_file');

      // Foreign key untuk id_pelamar
      $table
        ->foreign('id_pelamar')
        ->references('id_pelamar')
        ->on('pelamar')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();

      // Foreign key untuk id_jenis_dokumen
      $table
        ->foreign('id_jenis_dokumen')
        ->references('id_jenis_dokumen')
        ->on('dokumen')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('dokumen_pengguna');
  }
};
