<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TbUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_user')->insert([
            [
                'name' => 'Lilik',
                'email' => 'lilik@baginda.local',
                'email_verified_at' => now(),
                'password' => Hash::make('lilikajah'),
                'tb_hakakses_id' => 1, // administrator
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
