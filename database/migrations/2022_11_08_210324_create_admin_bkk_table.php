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
        Schema::create('admin_bkk', function (Blueprint $table) {
            $table->char('id_admin', 5)->primary();
            $table->integer('id_user');
            $table->string('nama_admin', 100);
            $table->char('nip', 18);

            // Foreign Key untuk id_user
            $table
                ->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('admin_bkk');
    }
};
