<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_absensi_santri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_santri_id');
            $table->unsignedBigInteger('tb_kelas_id');
            $table->unsignedBigInteger('tb_guru_id')->nullable();
            $table->date('tanggal');
            $table->string('status', 1); // H, S, I, A
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('tb_santri_id')->references('id')->on('tb_santri')->onDelete('cascade');
            $table->foreign('tb_kelas_id')->references('id')->on('tb_kelas')->onDelete('cascade');
            $table->foreign('tb_guru_id')->references('id')->on('tb_guru')->onDelete('set null');

            $table->unique(['tb_santri_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_absensi_santri');
    }
};
