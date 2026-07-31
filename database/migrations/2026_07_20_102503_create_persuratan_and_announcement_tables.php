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
        // 1. Table for generated letters (Pembuatan Surat Resmi)
        Schema::create('tb_surat_buat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('template_key')->default('kustom');
            $table->string('header_title')->default('TAKMIR MASJID BAGINDA');
            $table->text('header_subtitle')->nullable();
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->string('tujuan_surat')->nullable();
            $table->longText('isi_surat')->nullable();
            
            // Signatures (TTE) details
            $table->string('nama_sekretaris')->nullable();
            $table->enum('status_sekretaris', ['pending', 'signed'])->default('pending');
            $table->longText('ttd_sekretaris')->nullable(); // Base64 signature image
            
            $table->string('nama_ketua')->nullable();
            $table->enum('status_ketua', ['pending', 'signed'])->default('pending');
            $table->longText('ttd_ketua')->nullable(); // Base64 signature image
            
            $table->string('nama_penasehat')->nullable();
            $table->enum('status_penasehat', ['pending', 'signed'])->default('pending');
            $table->longText('ttd_penasehat')->nullable(); // Base64 signature image
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('tb_user')->onDelete('set null');
        });

        // 2. Table for Broadcast Templates (Master Template Pengumuman)
        Schema::create('tb_takmir_broadcast_template', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->text('isi_template');
            $table->timestamps();
        });

        // 3. Table for Broadcast Logs (Riwayat Pengumuman)
        Schema::create('tb_takmir_broadcast', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi_pengumuman');
            $table->string('target_type'); // semua_takmir, grup_wa, custom
            $table->text('target_detail')->nullable(); // list numbers or group ID
            $table->string('status')->default('sent');
            $table->integer('total_sent')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('tb_user')->onDelete('set null');
        });

        // Seed some default broadcast templates
        DB::table('tb_takmir_broadcast_template')->insert([
            [
                'nama_template' => 'Undangan Rapat Takmir',
                'isi_template' => "*_Assalamu'alaikum wr. wb._*\n\nKepada Yth. Pengurus Takmir Masjid Baginda,\n\nDengan ini kami mengundang Bapak/Ibu/Saudara sekalian untuk menghadiri rapat koordinasi yang akan dilaksanakan pada:\n\nHari/Tanggal: [Hari/Tanggal]\nWaktu: [Waktu] WIB\nTempat: [Tempat]\nAgenda: [Agenda rapat]\n\nKehadiran Bapak/Ibu sekalian sangat kami harapkan demi kelancaran program kerja masjid kita.\n\nDemikian undangan ini kami sampaikan. Terima kasih.\n\n*_Wassalamu'alaikum wr. wb._*",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_template' => 'Pengumuman Kegiatan Masjid',
                'isi_template' => "*_Assalamu'alaikum wr. wb._*\n\nDiberitahukan kepada seluruh Pengurus Takmir dan Jamaah Masjid Baginda, bahwasanya Masjid Baginda akan mengadakan kegiatan [Nama Kegiatan] pada:\n\nHari/Tanggal: [Hari/Tanggal]\nWaktu: [Waktu] WIB s/d Selesai\nPembicara/Pengisi: [Nama Pengisi]\n\nMari kita ramaikan dan makmurkan masjid kita dengan menghadiri majelis mulia ini.\n\nAtas perhatiannya kami ucapkan terima kasih.\n\n*_Wassalamu'alaikum wr. wb._*",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_takmir_broadcast');
        Schema::dropIfExists('tb_takmir_broadcast_template');
        Schema::dropIfExists('tb_surat_buat');
    }
};
