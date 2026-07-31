<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_prestasi_santri', function (Blueprint $table) {
            $table->unsignedBigInteger('tb_user_id')->nullable()->after('tb_guru_id');
            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('set null');
        });

        // Populate existing records
        $records = DB::table('tb_prestasi_santri')->get();
        foreach ($records as $record) {
            $userId = 1; // Default to admin Lilik
            if ($record->tb_guru_id) {
                $guru = DB::table('tb_guru')->where('id', $record->tb_guru_id)->first();
                if ($guru && $guru->tb_user_id) {
                    $userId = $guru->tb_user_id;
                }
            }
            DB::table('tb_prestasi_santri')->where('id', $record->id)->update([
                'tb_user_id' => $userId
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_prestasi_santri', function (Blueprint $table) {
            $table->dropForeign(['tb_user_id']);
            $table->dropColumn('tb_user_id');
        });
    }
};
