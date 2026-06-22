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
        Schema::create('tb_wa_template', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('template');
            $table->timestamps();
        });

        // Seed default WhatsApp SPP receipt template
        DB::table('tb_wa_template')->insert([
            'key' => 'spp_kuitansi',
            'template' => "Assalamu'alaikum wr. wb.\n\nTerima kasih, pembayaran SPP Ananda *{nama_santri}* untuk bulan *{bulan} {tahun}* sebesar *Rp {jumlah}* telah kami terima pada tanggal *{tanggal_bayar}*.\n\nSyukron jazakumullah khairan.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::create('tb_spp_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_santri_id');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('jumlah');
            $table->date('tanggal_bayar');
            $table->unsignedBigInteger('tb_user_id');
            $table->timestamps();

            $table->unique(['tb_santri_id', 'bulan', 'tahun']);
            $table->foreign('tb_santri_id')->references('id')->on('tb_santri')->onDelete('cascade');
            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('cascade');
        });

        Schema::create('tb_tpq_kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tipe'); // masuk / keluar
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('tb_spp_pembayaran_id')->nullable();
            $table->unsignedBigInteger('tb_user_id');
            $table->timestamps();

            $table->foreign('tb_spp_pembayaran_id')->references('id')->on('tb_spp_pembayaran')->onDelete('cascade');
            $table->foreign('tb_user_id')->references('id')->on('tb_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tpq_kas');
        Schema::dropIfExists('tb_spp_pembayaran');
        Schema::dropIfExists('tb_wa_template');
    }
};
