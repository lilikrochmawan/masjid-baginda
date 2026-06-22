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
        Schema::create('tb_pemilikkaleng', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_kaleng_id');
            $table->string('nama');
            $table->text('alamat');
            $table->date('tanggal_diserahkan');
            $table->timestamps();

            $table->foreign('tb_kaleng_id')->references('id')->on('tb_kaleng')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pemilikkaleng');
    }
};
