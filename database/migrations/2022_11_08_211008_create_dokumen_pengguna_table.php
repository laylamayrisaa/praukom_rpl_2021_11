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
        Schema::create('dokumen_pengguna', function (Blueprint $table) {
            $table->integer('id_dokumen_pengguna', true);
            $table->integer('id_pelamar');
            $table->char('id_jenis_dokumen', 7);
            $table->text('nama_file');
            $table->text('public_id')->nullable()->default(null);

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
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('dokumen_pengguna');
    }
};
