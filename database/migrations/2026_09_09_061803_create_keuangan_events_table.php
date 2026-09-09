<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keuangan_events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_transferred')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangan_events');
    }
};
