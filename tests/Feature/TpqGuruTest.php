<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\HakAkses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TbHakaksesSeeder;
use Tests\TestCase;

class TpqGuruTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TbHakaksesSeeder::class);
    }

    public function test_guru_dropdown_only_contains_tpq_and_guru_tpq_users()
    {
        $adminHak = HakAkses::firstOrCreate(
            ['nama_hakakses' => 'administrator'],
            ['deskripsi' => 'Admin']
        );
        $tpqHak = HakAkses::firstOrCreate(
            ['nama_hakakses' => 'tpq'],
            ['deskripsi' => 'TPQ']
        );
        $guruTpqHak = HakAkses::firstOrCreate(
            ['nama_hakakses' => 'guru tpq'],
            ['deskripsi' => 'Guru TPQ']
        );
        $bendaharaHak = HakAkses::firstOrCreate(
            ['nama_hakakses' => 'bendahara'],
            ['deskripsi' => 'Bendahara']
        );

        // Create users
        $admin = User::factory()->create(['tb_hakakses_id' => $adminHak->id]);
        $tpqUser = User::factory()->create(['name' => 'User TPQ', 'tb_hakakses_id' => $tpqHak->id]);
        $guruTpqUser = User::factory()->create(['name' => 'User Guru TPQ', 'tb_hakakses_id' => $guruTpqHak->id]);
        $bendaharaUser = User::factory()->create(['name' => 'User Bendahara', 'tb_hakakses_id' => $bendaharaHak->id]);

        $response = $this->actingAs($admin)->get('/tpq/guru');
        $response->assertStatus(200);

        // Assert view data contains the correct filtered users
        $loadedUsers = $response->viewData('users');
        $this->assertCount(2, $loadedUsers);
        $this->assertTrue($loadedUsers->contains($tpqUser));
        $this->assertTrue($loadedUsers->contains($guruTpqUser));
        $this->assertFalse($loadedUsers->contains($bendaharaUser));
        $this->assertFalse($loadedUsers->contains($admin));
    }
}
