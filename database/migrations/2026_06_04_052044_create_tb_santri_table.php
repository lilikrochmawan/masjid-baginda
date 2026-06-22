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
        Schema::create('tb_santri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_kelas_id')->nullable();
            $table->string('nis')->nullable()->unique();
            $table->string('nama_santri');
            $table->string('jenis_kelamin', 1); // L / P
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('no_hp_orang_tua')->nullable();
            $table->timestamps();

            $table->foreign('tb_kelas_id')->references('id')->on('tb_kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_santri');
    }
};
