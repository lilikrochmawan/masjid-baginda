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
        Schema::create('tb_guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_user_id')->nullable()->unique();
            $table->string('nip')->nullable()->unique();
            $table->string('nama_guru');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();

            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_guru');
    }
};
