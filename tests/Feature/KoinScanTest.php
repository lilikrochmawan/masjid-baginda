<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Models\HakAkses;
use App\Models\Kaleng;
use App\Models\PemilikKaleng;
use App\Models\TransaksiKaleng;
use App\Models\WaTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TbHakaksesSeeder;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class KoinScanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TbHakaksesSeeder::class);
    }

    public function test_can_create_pemilik_kaleng_with_no_wa()
    {
        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $kaleng = Kaleng::create([
            'kode_kaleng' => 'BGD00001',
            'nama_kaleng' => 'Kaleng RT 01',
        ]);

        $payload = [
            'nama' => 'Ahmad',
            'alamat' => 'Jl. Mawar No. 5',
            'no_wa' => '081299998888',
            'tb_kaleng_id' => $kaleng->id,
            'tanggal_diserahkan' => '2026-06-04',
        ];

        $response = $this->actingAs($admin)->post('/koin-baginda/pemilik', $payload);
        $response->assertRedirect('/koin-baginda/pemilik');
        $response->assertSessionHas('success', 'Data pemilik kaleng berhasil disimpan.');

        $this->assertDatabaseHas('tb_pemilikkaleng', [
            'nama' => 'Ahmad',
            'no_wa' => '081299998888',
            'tb_kaleng_id' => $kaleng->id,
        ]);
    }

    public function test_can_update_pemilik_kaleng_no_wa()
    {
        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $kaleng = Kaleng::create([
            'kode_kaleng' => 'BGD00001',
            'nama_kaleng' => 'Kaleng RT 01',
        ]);

        $pemilik = PemilikKaleng::create([
            'nama' => 'Ahmad',
            'alamat' => 'Jl. Mawar No. 5',
            'no_wa' => '081299998888',
            'tb_kaleng_id' => $kaleng->id,
            'tanggal_diserahkan' => '2026-06-04',
        ]);

        $payload = [
            'nama' => 'Ahmad Fauzi',
            'alamat' => 'Jl. Melati No. 10',
            'no_wa' => '089988887777',
        ];

        $response = $this->actingAs($admin)->put("/koin-baginda/pemilik/{$pemilik->id}", $payload);
        $response->assertRedirect('/koin-baginda/inventory');
        $response->assertSessionHas('success', 'Data pemilik berhasil diperbarui.');

        $this->assertDatabaseHas('tb_pemilikkaleng', [
            'id' => $pemilik->id,
            'nama' => 'Ahmad Fauzi',
            'no_wa' => '089988887777',
            'alamat' => 'Jl. Melati No. 10',
        ]);
    }

    public function test_scan_sends_whatsapp_message_with_correct_template()
    {
        Http::fake([
            'api.fonnte.com/*' => Http::response(['status' => true], 200),
        ]);

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $kaleng = Kaleng::create([
            'kode_kaleng' => 'BGD00001',
            'nama_kaleng' => 'Kaleng RT 01',
        ]);

        $pemilik = PemilikKaleng::create([
            'nama' => 'Ahmad',
            'alamat' => 'Jl. Mawar No. 5',
            'no_wa' => '081299998888',
            'tb_kaleng_id' => $kaleng->id,
            'tanggal_diserahkan' => '2026-06-04',
        ]);

        putenv('FONNTE_TOKEN=koin-token-env');

        $payload = [
            'kode_kaleng' => 'BGD00001',
            'tanggal_ambil' => '2026-06-04',
        ];

        $response = $this->actingAs($admin)->post('/koin-baginda/transaksi', $payload);
        $response->assertRedirect('/koin-baginda/transaksi');
        $response->assertSessionHas('success');

        Http::assertSent(function ($request) {
            $hasToken = $request->hasHeader('Authorization', 'koin-token-env');
            $body = $request->body();
            parse_str($body, $data);
            $hasTarget = isset($data['target']) && $data['target'] === '6281299998888';
            $hasMessage = isset($data['message']) && str_contains($data['message'], 'Ahmad') && str_contains($data['message'], 'BGD00001') && str_contains($data['message'], 'Kaleng RT 01');
            return $hasToken && $hasTarget && $hasMessage;
        });

        // Ensure template was created in database
        $this->assertDatabaseHas('tb_wa_template', [
            'key' => 'koin_scan',
        ]);
    }
}
