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
        Schema::create('tb_setting', function (Blueprint $table) {
            $table->id();
            $table->text('fonnte_token')->nullable();
            $table->string('midtrans_client_id')->nullable();
            $table->string('midtrans_server_key')->nullable();
            $table->string('midtrans_environment')->default('sandbox');
            $table->timestamps();
        });

        // Seed initial configuration row
        DB::table('tb_setting')->insert([
            'id' => 1,
            'fonnte_token' => null,
            'midtrans_client_id' => null,
            'midtrans_server_key' => null,
            'midtrans_environment' => 'sandbox',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_setting');
    }
};
