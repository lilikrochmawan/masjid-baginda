<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\HakAkses;
use App\Models\Takmir;
use App\Models\JenisBarang;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Surat;
use App\Models\RencanaKerja;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OperasionalTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $operator;
    private $noAccessUser;

    protected function setUp(): void
    {
        parent::setUp();

        $adminHak = HakAkses::firstOrCreate(['nama_hakakses' => 'administrator'], ['deskripsi' => 'Administrator']);
        $opHak = HakAkses::firstOrCreate(['nama_hakakses' => 'operator'], ['deskripsi' => 'Operator']);

        $this->admin = User::factory()->create(['tb_hakakses_id' => $adminHak->id]);
        
        $this->operator = User::factory()->create([
            'tb_hakakses_id' => $opHak->id,
            'akses_modul' => ['operasional', 'operasional.struktur', 'operasional.inventaris', 'operasional.surat', 'operasional.rencana']
        ]);

        $this->noAccessUser = User::factory()->create([
            'tb_hakakses_id' => $opHak->id,
            'akses_modul' => []
        ]);
    }

    public function test_non_admin_without_permission_is_forbidden()
    {
        $this->actingAs($this->noAccessUser)
             ->get('/operasional')
             ->assertStatus(403);
    }

    public function test_admin_can_access_dashboard()
    {
        $this->actingAs($this->admin)
             ->get('/operasional')
             ->assertStatus(200);
    }

    public function test_operator_can_access_dashboard()
    {
        $this->actingAs($this->operator)
             ->get('/operasional')
             ->assertStatus(200);
    }

    public function test_struktur_organisasi_crud()
    {
        // 1. View
        $response = $this->actingAs($this->operator)->get('/operasional/struktur');
        $response->assertStatus(200);

        // 2. Create
        $data = [
            'nama' => 'H. Ahmad',
            'jabatan' => 'Ketua Takmir',
            'parent_id' => null,
            'no_hp' => '08123456789',
            'status' => 'aktif'
        ];
        $this->actingAs($this->operator)
             ->post('/operasional/struktur', $data)
             ->assertRedirect(route('operasional.struktur.index'));

        $this->assertDatabaseHas('tb_takmir', ['nama' => 'H. Ahmad', 'jabatan' => 'Ketua Takmir']);
        $member = Takmir::where('nama', 'H. Ahmad')->first();

        // 3. Update
        $data['nama'] = 'H. Ahmad S.Ag';
        $this->actingAs($this->operator)
             ->put('/operasional/struktur/' . $member->id, $data)
             ->assertRedirect(route('operasional.struktur.index'));

        $this->assertDatabaseHas('tb_takmir', ['nama' => 'H. Ahmad S.Ag']);

        // 4. Delete
        $this->actingAs($this->operator)
             ->delete('/operasional/struktur/' . $member->id)
             ->assertRedirect(route('operasional.struktur.index'));

        $this->assertDatabaseMissing('tb_takmir', ['id' => $member->id]);
    }

    public function test_inventaris_crud_and_auto_code_generation()
    {
        // 1. View
        $this->actingAs($this->operator)->get('/operasional/inventaris')->assertStatus(200);

        // 2. Create Category (Jenis)
        $jenisData = ['nama_jenis' => 'Elektronik', 'keterangan' => 'Barang elektronik masjid'];
        $this->actingAs($this->operator)
             ->post('/operasional/jenis-barang', $jenisData)
             ->assertRedirect(route('operasional.inventaris.index', ['tab' => 'jenis']));

        $this->assertDatabaseHas('tb_jenis_barang', ['nama_jenis' => 'Elektronik']);
        $jenis = JenisBarang::where('nama_jenis', 'Elektronik')->first();

        // 3. Create Master Barang
        $barangData = [
            'tb_jenis_barang_id' => $jenis->id,
            'nama_barang' => 'AC Panasonic 2PK',
            'satuan' => 'Unit',
            'keterangan' => 'Ruang utama'
        ];
        $this->actingAs($this->operator)
             ->post('/operasional/barang', $barangData)
             ->assertRedirect(route('operasional.inventaris.index', ['tab' => 'barang']));

        $this->assertDatabaseHas('tb_barang', ['nama_barang' => 'AC Panasonic 2PK']);
        $barang = Barang::where('nama_barang', 'AC Panasonic 2PK')->first();

        // 4. Create Unit Inventaris (Auto code generation check)
        $inventarisData = [
            'tb_barang_id' => $barang->id,
            'tanggal_perolehan' => '2026-06-01',
            'asal_usul' => 'Pembelian Kas',
            'kondisi' => 'baik',
            'lokasi' => 'Ruang Imam',
            'harga_perolehan' => 7500000
        ];
        $this->actingAs($this->operator)
             ->post('/operasional/inventaris', $inventarisData)
             ->assertRedirect(route('operasional.inventaris.index', ['tab' => 'inventaris']));

        // Code should be INV-ELE-00X-0001 (based on conversion)
        $this->assertDatabaseHas('tb_inventaris', [
            'tb_barang_id' => $barang->id,
            'kode_inventaris' => 'INV-ELE-00' . $barang->id . '-0001',
            'lokasi' => 'Ruang Imam'
        ]);
        
        $inv = Inventaris::where('tb_barang_id', $barang->id)->first();

        // 5. Update
        $inventarisData['lokasi'] = 'Mihrab';
        $this->actingAs($this->operator)
             ->put('/operasional/inventaris/' . $inv->id, $inventarisData)
             ->assertRedirect(route('operasional.inventaris.index', ['tab' => 'inventaris']));

        $this->assertDatabaseHas('tb_inventaris', ['id' => $inv->id, 'lokasi' => 'Mihrab']);

        // 6. Delete
        $this->actingAs($this->operator)
             ->delete('/operasional/inventaris/' . $inv->id)
             ->assertRedirect(route('operasional.inventaris.index', ['tab' => 'inventaris']));

        $this->assertDatabaseMissing('tb_inventaris', ['id' => $inv->id]);
    }

    public function test_persuratan_crud_with_file_upload()
    {
        Storage::fake('public');

        $this->actingAs($this->operator)->get('/operasional/surat')->assertStatus(200);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $suratData = [
            'tipe' => 'proposal',
            'nomor_surat' => '005/PROP/2026',
            'tanggal_surat' => '2026-06-04',
            'tanggal_diterima' => '2026-06-04',
            'pengirim' => 'Ikatan Remaja Masjid',
            'perihal' => 'Pengajuan Dana Kajian Pemuda',
            'status_proposal' => 'pending',
            'keterangan' => 'Butuh ACC cepat',
            'file_dokumen' => $file
        ];

        $this->actingAs($this->operator)
             ->post('/operasional/surat', $suratData)
             ->assertRedirect(route('operasional.surat.index'));

        $surat = Surat::where('nomor_surat', '005/PROP/2026')->first();
        $this->assertNotNull($surat);
        $this->assertNotNull($surat->file_path);
        
        // Assert file exists in storage
        Storage::disk('public')->assertExists($surat->file_path);

        // Delete
        $filePath = $surat->file_path;
        $this->actingAs($this->operator)
             ->delete('/operasional/surat/' . $surat->id)
             ->assertRedirect(route('operasional.surat.index'));

        $this->assertDatabaseMissing('tb_surat', ['id' => $surat->id]);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function test_rencana_kerja_crud()
    {
        $takmir = Takmir::create([
            'nama' => 'H. Suhada',
            'jabatan' => 'Seksi Ibadah',
            'status' => 'aktif'
        ]);

        $this->actingAs($this->operator)->get('/operasional/rencana-kerja')->assertStatus(200);

        $rencanaData = [
            'tb_takmir_id' => $takmir->id,
            'nama_program' => 'Kajian Rutin Malam Jumat',
            'deskripsi' => 'Pengajian yasinan dan tahlil',
            'anggaran' => 500000,
            'target_selesai' => '2026-07-01',
            'status' => 'belum_mulai'
        ];

        $this->actingAs($this->operator)
             ->post('/operasional/rencana-kerja', $rencanaData)
             ->assertRedirect(route('operasional.rencana.index'));

        $this->assertDatabaseHas('tb_rencana_kerja', ['nama_program' => 'Kajian Rutin Malam Jumat']);
        $rencana = RencanaKerja::where('nama_program', 'Kajian Rutin Malam Jumat')->first();

        // Update
        $rencanaData['status'] = 'sedang_berjalan';
        $this->actingAs($this->operator)
             ->put('/operasional/rencana-kerja/' . $rencana->id, $rencanaData)
             ->assertRedirect(route('operasional.rencana.index'));

        $this->assertDatabaseHas('tb_rencana_kerja', ['id' => $rencana->id, 'status' => 'sedang_berjalan']);

        // Delete
        $this->actingAs($this->operator)
             ->delete('/operasional/rencana-kerja/' . $rencana->id)
             ->assertRedirect(route('operasional.rencana.index'));

        $this->assertDatabaseMissing('tb_rencana_kerja', ['id' => $rencana->id]);
    }
}
