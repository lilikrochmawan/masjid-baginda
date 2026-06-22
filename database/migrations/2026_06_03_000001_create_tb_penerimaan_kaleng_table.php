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
        Schema::create('tb_penerimaan_kaleng', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_kaleng_id');
            $table->date('tanggal_penerimaan');
            $table->integer('jumlah');
            $table->unsignedBigInteger('tb_user_id');
            $table->timestamps();

            $table->foreign('tb_kaleng_id')->references('id')->on('tb_kaleng')->onDelete('cascade');
            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_penerimaan_kaleng');
    }
};
