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
        // 1. Create tb_tpq_master_hafalan table
        Schema::create('tb_tpq_master_hafalan', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['surah_pendek', 'doa_harian']);
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Seed some default master items
        $defaultHafalan = [
            ['kategori' => 'surah_pendek', 'nama' => 'Surah An-Nas'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Falaq'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Ikhlas'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Lahab'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah An-Nasr'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Kafirun'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Kautsar'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Ma\'un'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Quraish'],
            ['kategori' => 'surah_pendek', 'nama' => 'Surah Al-Fil'],
            
            ['kategori' => 'doa_harian', 'nama' => 'Doa Sebelum Makan'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Sesudah Makan'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Sebelum Tidur'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Bangun Tidur'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Masuk Masjid'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Keluar Masjid'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Kedua Orang Tua'],
            ['kategori' => 'doa_harian', 'nama' => 'Doa Kebaikan Dunia Akhirat'],
        ];

        foreach ($defaultHafalan as $item) {
            DB::table('tb_tpq_master_hafalan')->insert(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // 2. Create tb_prestasi_santri table
        Schema::create('tb_prestasi_santri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tb_santri_id');
            $table->unsignedBigInteger('tb_guru_id')->nullable();
            $table->date('tanggal');
            $table->enum('tipe', ['sorogan', 'hafalan']);
            $table->enum('materi', ['iqro', 'alquran', 'juz_amma'])->nullable();
            $table->integer('iqro_jilid')->nullable();
            $table->integer('iqro_halaman')->nullable();
            $table->string('alquran_surah')->nullable();
            $table->string('alquran_ayat')->nullable();
            $table->string('juz_amma_surah')->nullable();
            $table->string('juz_amma_ayat')->nullable();
            $table->unsignedBigInteger('tb_tpq_master_hafalan_id')->nullable();
            $table->enum('keterangan', ['lanjut', 'ulang']);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('tb_santri_id')->references('id')->on('tb_santri')->onDelete('cascade');
            $table->foreign('tb_guru_id')->references('id')->on('tb_guru')->onDelete('set null');
            $table->foreign('tb_tpq_master_hafalan_id')->references('id')->on('tb_tpq_master_hafalan')->onDelete('set null');
        });

        // 3. Add prestasi_token to tb_santri table
        Schema::table('tb_santri', function (Blueprint $table) {
            $table->string('prestasi_token')->nullable()->unique()->after('no_hp_orang_tua');
        });

        // Generate tokens for existing students
        $santris = DB::table('tb_santri')->get();
        foreach ($santris as $s) {
            DB::table('tb_santri')->where('id', $s->id)->update([
                'prestasi_token' => bin2hex(random_bytes(16))
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_santri', function (Blueprint $table) {
            $table->dropColumn('prestasi_token');
        });

        Schema::dropIfExists('tb_prestasi_santri');
        Schema::dropIfExists('tb_tpq_master_hafalan');
    }
};
