<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Models\HakAkses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TbHakaksesSeeder;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TbHakaksesSeeder::class);
    }

    public function test_guest_cannot_access_settings()
    {
        $response = $this->get('/settings');
        $response->assertRedirect('/login');
    }

    public function test_user_without_permission_cannot_access_settings()
    {
        $hakAkses = HakAkses::where('nama_hakakses', 'operator')->first();
        $user = User::factory()->create([
            'tb_hakakses_id' => $hakAkses->id,
            'akses_modul' => [],
        ]);

        $response = $this->actingAs($user)->get('/settings');
        $response->assertStatus(403);
    }

    public function test_user_with_permission_can_access_settings()
    {
        $hakAkses = HakAkses::where('nama_hakakses', 'operator')->first();
        $user = User::factory()->create([
            'tb_hakakses_id' => $hakAkses->id,
            'akses_modul' => ['tentang'],
        ]);

        $response = $this->actingAs($user)->get('/settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Sistem');
    }

    public function test_admin_can_access_settings_by_default()
    {
        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $response = $this->actingAs($admin)->get('/settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Sistem');
    }

    public function test_admin_can_update_settings()
    {
        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'id' => 1,
                'fonnte_token' => null,
                'midtrans_client_id' => null,
                'midtrans_server_key' => null,
                'midtrans_environment' => 'sandbox',
            ]);
        }

        $payload = [
            'fonnte_token' => 'test-fonnte-token-123',
            'midtrans_client_id' => 'test-midtrans-client-123',
            'midtrans_server_key' => 'test-midtrans-server-123',
            'midtrans_environment' => 'production',
        ];

        $response = $this->actingAs($admin)->post('/settings', $payload);
        $response->assertRedirect('/settings?tab=api');
        $response->assertSessionHas('success', 'Kredensial API berhasil diperbarui.');

        $setting->refresh();
        $this->assertEquals('test-fonnte-token-123', $setting->fonnte_token);
        $this->assertEquals('test-midtrans-client-123', $setting->midtrans_client_id);
        $this->assertEquals('test-midtrans-server-123', $setting->midtrans_server_key);
        $this->assertEquals('production', $setting->midtrans_environment);
    }

    public function test_fonnte_token_priority_and_fallback()
    {
        // Fake the HTTP request
        \Illuminate\Support\Facades\Http::fake([
            'api.fonnte.com/*' => \Illuminate\Support\Facades\Http::response(['status' => true], 200),
        ]);

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        // Create a kelas
        $kelas = \App\Models\Kelas::create([
            'nama_kelas' => 'Jilid 1',
        ]);

        // Create a santri
        $santri = \App\Models\Santri::create([
            'nama_santri' => 'Budi',
            'no_hp_orang_tua' => '081234567890',
            'tb_kelas_id' => $kelas->id,
            'nis' => '0001',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2015-01-01',
            'nama_orang_tua' => 'Orang Tua Budi',
        ]);

        // Case 1: No settings in DB, should fallback to env('FONNTE_TOKEN')
        putenv('FONNTE_TOKEN=env-token-xyz');
        Setting::truncate();

        // Create a payment
        $payment = \App\Models\SppPembayaran::create([
            'tb_santri_id' => $santri->id,
            'bulan' => 6,
            'tahun' => 2026,
            'jumlah' => 20000,
            'tanggal_bayar' => '2026-06-04',
            'tb_user_id' => $admin->id,
        ]);

        // Call sppBroadcast via route
        $response = $this->actingAs($admin)->post("/tpq/keuangan/spp/{$payment->id}/broadcast");
        $response->assertRedirect();
        
        // Assert that the request used the env-token-xyz
        \Illuminate\Support\Facades\Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'env-token-xyz');
        });

        // Case 2: Settings exist in DB, should use the DB token instead of env
        \Illuminate\Support\Facades\Http::fake([
            'api.fonnte.com/*' => \Illuminate\Support\Facades\Http::response(['status' => true], 200),
        ]);

        Setting::create([
            'id' => 1,
            'fonnte_token' => 'db-token-abc',
            'midtrans_environment' => 'sandbox',
        ]);

        $response = $this->actingAs($admin)->post("/tpq/keuangan/spp/{$payment->id}/broadcast");
        $response->assertRedirect();

        // Assert that the request used the db-token-abc
        \Illuminate\Support\Facades\Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'db-token-abc');
        });
    }

    public function test_admin_can_update_whatsapp_templates()
    {
        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        // Load page first to auto-initialize default templates
        $response = $this->actingAs($admin)->get('/settings');
        $response->assertStatus(200);

        $payload = [
            'templates' => [
                [
                    'key' => 'spp_kuitansi',
                    'template' => 'New SPP kuitansi template {nama_santri} {bulan}',
                ],
                [
                    'key' => 'koin_scan',
                    'template' => 'New Koin scan template {nama_pemilik}',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post('/settings/templates', $payload);
        $response->assertRedirect('/settings?tab=templates');
        $response->assertSessionHas('success', 'Template WhatsApp berhasil diperbarui.');

        $this->assertDatabaseHas('tb_wa_template', [
            'key' => 'spp_kuitansi',
            'template' => 'New SPP kuitansi template {nama_santri} {bulan}',
        ]);

        $this->assertDatabaseHas('tb_wa_template', [
            'key' => 'koin_scan',
            'template' => 'New Koin scan template {nama_pemilik}',
        ]);
    }

    public function test_admin_can_update_login_background()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('custom_mosque.jpg');

        $response = $this->actingAs($admin)->post('/settings/login-bg', [
            'foto_masjid' => $file,
        ]);

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Foto background login berhasil diperbarui.');

        $setting = Setting::first();
        $this->assertNotNull($setting->foto_masjid);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($setting->foto_masjid);
    }

    public function test_admin_can_reset_login_background()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'id' => 1,
                'midtrans_environment' => 'sandbox',
            ]);
        }
        
        $setting->foto_masjid = 'settings/custom_mosque.jpg';
        $setting->save();

        $response = $this->actingAs($admin)->post('/settings/login-bg/reset');

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Background login telah di-reset ke default.');

        $setting->refresh();
        $this->assertNull($setting->foto_masjid);
    }

    public function test_admin_can_update_logo()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('custom_logo.png');

        $response = $this->actingAs($admin)->post('/settings/logo', [
            'logo' => $file,
        ]);

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Logo aplikasi berhasil diperbarui.');

        $setting = Setting::first();
        $this->assertNotNull($setting->logo);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($setting->logo);
    }

    public function test_admin_can_reset_logo()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'id' => 1,
                'midtrans_environment' => 'sandbox',
            ]);
        }
        
        $setting->logo = 'settings/custom_logo.png';
        $setting->save();

        $response = $this->actingAs($admin)->post('/settings/logo/reset');

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Logo aplikasi telah di-reset ke default.');

        $setting->refresh();
        $this->assertNull($setting->logo);
    }

    public function test_admin_can_upload_announcement()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('announcement.jpg');

        $response = $this->actingAs($admin)->post('/settings/pengumuman', [
            'image' => $file,
            'title' => 'Pengumuman 1',
        ]);

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Gambar pengumuman berhasil diunggah.');

        $this->assertDatabaseHas('tb_pengumuman', [
            'title' => 'Pengumuman 1',
        ]);

        $pengumuman = \App\Models\Pengumuman::first();
        $this->assertNotNull($pengumuman);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($pengumuman->image_path);
    }

    public function test_admin_can_delete_announcement()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $adminHak = HakAkses::where('nama_hakakses', 'administrator')->first();
        $admin = User::factory()->create([
            'tb_hakakses_id' => $adminHak->id,
        ]);

        $pengumuman = \App\Models\Pengumuman::create([
            'image_path' => 'pengumuman/test_announcement.jpg',
            'title' => 'Pengumuman 2',
        ]);

        // Place a fake file in the storage so it gets deleted
        \Illuminate\Support\Facades\Storage::disk('public')->put($pengumuman->image_path, 'dummy content');

        $response = $this->actingAs($admin)->delete('/settings/pengumuman/' . $pengumuman->id);

        $response->assertRedirect('/settings?tab=login');
        $response->assertSessionHas('success', 'Gambar pengumuman berhasil dihapus.');

        $this->assertDatabaseMissing('tb_pengumuman', [
            'id' => $pengumuman->id,
        ]);

        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($pengumuman->image_path);
    }
}
