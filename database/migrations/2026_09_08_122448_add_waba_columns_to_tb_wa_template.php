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
        Schema::table('tb_wa_template', function (Blueprint $table) {
            $table->string('waba_template_name')->nullable();
            $table->string('waba_template_language')->nullable();
            $table->string('waba_template_variables')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_wa_template', function (Blueprint $table) {
            $table->dropColumn(['waba_template_name', 'waba_template_language', 'waba_template_variables']);
        });
    }
};
