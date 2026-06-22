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
        Schema::create('tb_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->unsignedBigInteger('tb_guru_id')->nullable();
            $table->timestamps();

            $table->foreign('tb_guru_id')->references('id')->on('tb_guru')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kelas');
    }
};
