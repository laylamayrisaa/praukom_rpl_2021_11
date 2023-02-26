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
        Schema::create('siswa_alumni', function (Blueprint $table) {
            $table->integer('id_siswa', true);
            $table->integer('id_pelamar');
            $table->char('id_angkatan', 8);
            $table->char('id_jurusan', 7);
            $table->string('nis', 18)->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable()->default(null);
            $table->date('tanggal_lahir')->nullable()->default(null);
            $table->string('no_telepon', 20)->nullable()->default(null);
            $table->text('alamat_tempat_tinggal')->nullable()->default(null);
            $table->text('foto')->nullable()->default(null);
            $table->text('public_foto_id')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(true);
            $table
                ->enum('status_kegiatan', ['Mahasiswa', 'Bekerja', 'Wirausaha', 'Belum Memiliki Kegiatan'])
                ->nullable()
                ->default(null);

            // Foreign key untuk id_pelamar
            $table
                ->foreign('id_pelamar')
                ->references('id_pelamar')
                ->on('pelamar')
                ->cascadeOnUpdate();

            // Foreign key untuk id_angkatan
            $table
                ->foreign('id_angkatan')
                ->references('id_angkatan')
                ->on('angkatan')
                ->cascadeOnUpdate();

            // Foreign key untuk id_jurusan
            $table
                ->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusan')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('siswa_alumni');
    }
};
