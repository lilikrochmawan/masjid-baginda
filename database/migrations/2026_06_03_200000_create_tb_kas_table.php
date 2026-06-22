<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_kas');
            $table->string('tipe');
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('tb_user_id');
            $table->unsignedBigInteger('tb_penerimaan_kaleng_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('cascade');
            $table->foreign('tb_penerimaan_kaleng_id')->references('id')->on('tb_penerimaan_kaleng')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_kas');
    }
};
