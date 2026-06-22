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
        // 1. tb_takmir
        Schema::create('tb_takmir', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->foreignId('parent_id')->nullable()->constrained('tb_takmir')->nullOnDelete();
            $table->string('no_hp')->nullable();
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif');
            $table->timestamps();
        });

        // 2. tb_jenis_barang
        Schema::create('tb_jenis_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 3. tb_barang
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tb_jenis_barang_id')->constrained('tb_jenis_barang')->cascadeOnDelete();
            $table->string('nama_barang');
            $table->string('satuan')->default('Unit');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 4. tb_inventaris
        Schema::create('tb_inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tb_barang_id')->constrained('tb_barang')->cascadeOnDelete();
            $table->string('kode_inventaris')->unique();
            $table->date('tanggal_perolehan');
            $table->string('asal_usul')->default('Pembelian Kas');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->string('lokasi');
            $table->decimal('harga_perolehan', 15, 2)->nullable();
            $table->timestamps();
        });

        // 5. tb_surat
        Schema::create('tb_surat', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['masuk', 'keluar', 'proposal']);
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->string('perihal');
            $table->string('file_path')->nullable();
            $table->enum('status_proposal', ['pending', 'disetujui', 'ditolak'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 6. tb_rencana_kerja
        Schema::create('tb_rencana_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tb_takmir_id')->nullable()->constrained('tb_takmir')->nullOnDelete();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->date('target_selesai');
            $table->enum('status', ['belum_mulai', 'sedang_berjalan', 'selesai', 'dibatalkan'])->default('belum_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_rencana_kerja');
        Schema::dropIfExists('tb_surat');
        Schema::dropIfExists('tb_inventaris');
        Schema::dropIfExists('tb_barang');
        Schema::dropIfExists('tb_jenis_barang');
        Schema::dropIfExists('tb_takmir');
    }
};
