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
        Schema::create('tb_transaksi_kaleng', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_kaleng_id');
            $table->date('tanggal_ambil');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('tb_kaleng_id')->references('id')->on('tb_kaleng')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi_kaleng');
    }
};
