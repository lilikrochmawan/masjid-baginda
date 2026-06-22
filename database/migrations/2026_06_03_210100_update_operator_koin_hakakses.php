<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $record = DB::table('tb_hakakses')->where('nama_hakakses', 'operator_koin')->first();

        if ($record) {
            DB::table('tb_hakakses')
                ->where('nama_hakakses', 'operator_koin')
                ->update([
                    'deskripsi' => 'Operator koin yang hanya dapat mengakses modul Koin',
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('tb_hakakses')->insert([
                'nama_hakakses' => 'operator_koin',
                'deskripsi' => 'Operator koin yang hanya dapat mengakses modul Koin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tb_hakakses')->where('nama_hakakses', 'operator_koin')->delete();
    }
};
