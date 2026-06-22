<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TbHakaksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_hakakses')->insertOrIgnore([
            [
                'nama_hakakses' => 'administrator',
                'deskripsi' => 'Admin dengan akses penuh ke sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hakakses' => 'operator',
                'deskripsi' => 'Operator pengelola data operasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hakakses' => 'bendahara',
                'deskripsi' => 'Bendahara pengelola keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hakakses' => 'tpq',
                'deskripsi' => 'Pengelola TPQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hakakses' => 'operator_koin',
                'deskripsi' => 'Operator koin yang hanya dapat mengakses modul Koin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
