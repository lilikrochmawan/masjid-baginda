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
        Schema::table('tb_santri', function (Blueprint $table) {
            $table->string('alamat_rumah', 1000)->nullable()->after('tanggal_lahir');
            $table->string('nama_ayah', 255)->nullable()->after('alamat_rumah');
            $table->string('nama_ibu', 255)->nullable()->after('nama_ayah');
        });

        // Copy existing nama_orang_tua into nama_ayah as fallback
        \Illuminate\Support\Facades\DB::statement("UPDATE tb_santri SET nama_ayah = nama_orang_tua");

        Schema::table('tb_santri', function (Blueprint $table) {
            $table->dropColumn('nama_orang_tua');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_santri', function (Blueprint $table) {
            $table->string('nama_orang_tua', 255)->nullable()->after('tanggal_lahir');
        });

        // Copy back from nama_ayah/nama_ibu
        \Illuminate\Support\Facades\DB::statement("UPDATE tb_santri SET nama_orang_tua = COALESCE(nama_ayah, nama_ibu)");

        Schema::table('tb_santri', function (Blueprint $table) {
            $table->dropColumn(['alamat_rumah', 'nama_ayah', 'nama_ibu']);
        });
    }
};
