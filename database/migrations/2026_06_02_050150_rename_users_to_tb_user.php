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
        Schema::rename('users', 'tb_user');
        
        Schema::table('tb_user', function (Blueprint $table) {
            $table->unsignedBigInteger('tb_hakakses_id')->default(2)->after('id');
            $table->foreign('tb_hakakses_id')->references('id')->on('tb_hakakses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_user', function (Blueprint $table) {
            $table->dropForeign(['tb_hakakses_id']);
            $table->dropColumn('tb_hakakses_id');
        });
        
        Schema::rename('tb_user', 'users');
    }
};
