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
        Schema::create('tb_kelas_guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_kelas_id');
            $table->unsignedBigInteger('tb_guru_id');
            $table->timestamps();

            $table->foreign('tb_kelas_id')->references('id')->on('tb_kelas')->onDelete('cascade');
            $table->foreign('tb_guru_id')->references('id')->on('tb_guru')->onDelete('cascade');
            $table->unique(['tb_kelas_id', 'tb_guru_id']);
        });

        // Migrate existing relationships
        $existing = \DB::table('tb_kelas')->whereNotNull('tb_guru_id')->get();
        foreach ($existing as $item) {
            \DB::table('tb_kelas_guru')->insert([
                'tb_kelas_id' => $item->id,
                'tb_guru_id' => $item->tb_guru_id,
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
        Schema::dropIfExists('tb_kelas_guru');
    }
};
