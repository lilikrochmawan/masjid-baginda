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
        Schema::table('tb_transaksi_kaleng', function (Blueprint $table) {
            $table->unsignedBigInteger('tb_user_id')->nullable()->after('keterangan');
            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tb_transaksi_kaleng', function (Blueprint $table) {
            $table->dropForeign(['tb_user_id']);
            $table->dropColumn('tb_user_id');
        });
    }
};
