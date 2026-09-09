<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keuangan_event_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keuangan_event_id')->constrained('keuangan_events')->onDelete('cascade');
            $table->date('tanggal_kas');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangan_event_transaksis');
    }
};
