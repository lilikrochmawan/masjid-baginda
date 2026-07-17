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
        Schema::table('tb_setting', function (Blueprint $table) {
            $table->string('foto_masjid')->nullable()->after('midtrans_environment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_setting', function (Blueprint $table) {
            $table->dropColumn('foto_masjid');
        });
    }
};
