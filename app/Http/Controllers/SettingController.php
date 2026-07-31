<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WaTemplate;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('tentang')) {
                abort(403, 'Anda tidak memiliki hak akses untuk Pengaturan Sistem.');
            }
            return $next($request);
        });
    }

    /**
     * Display the settings form.
     */
    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

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

        // Initialize default templates if not exist in database
        $defaultTemplates = [
            'spp_kuitansi' => "*_Assalamu'alaikum wr. wb._*\n\nYth Wali Santri *{nama_santri}*\n\nTerima kasih, pembayaran SPP Ananda *{nama_santri}* untuk bulan *{bulan} {tahun}* sebesar *Rp {jumlah}* telah kami terima pada tanggal *{tanggal_bayar}*.\n\nSyukron jazakumullah khairan.",
            'koin_scan' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Bapak/Ibu *{nama_pemilik}*,\n\nKaleng dengan kode *{kode_kaleng}* ({nama_kaleng}) telah berhasil discan / diambil oleh petugas *{nama_petugas}* pada tanggal *{tanggal_ambil}*.\n\nTerima kasih atas infak dan partisipasi Anda dalam program Koin Baginda. Semoga menjadi amal jariyah dan membawa berkah bagi keluarga.\n\n*_Wassalamu'alaikum wr. wb._*",
            'tpq_absensi' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Orang Tua/Wali dari *{nama_santri}*,\n\nKami menginfokan bahwa Ananda *{nama_santri}* pada hari ini, *{tanggal}*, dinyatakan *{status}* dalam kegiatan pembelajaran TPQ Baginda.\n\nKeterangan: {keterangan}\n\nTerima kasih atas perhatiannya.\n\n*_Wassalamu'alaikum wr. wb._*",
            'tpq_prestasi_sorogan' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Wali Santri dari *{nama_santri}*,\n\nKami menginfokan perkembangan belajar Sorogan Ananda pada hari ini ({tanggal}):\n- Materi: {materi_detail}\n- Keterangan: {keterangan} (Petugas: {nama_petugas})\n\nLihat riwayat perkembangan kartu prestasi Ananda secara lengkap pada tautan berikut:\n{link_prestasi}\n\nTerima kasih atas perhatiannya.\n\n*_Wassalamu'alaikum wr. wb._*",
            'tpq_prestasi_hafalan' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Wali Santri dari *{nama_santri}*,\n\nKami menginfokan perkembangan belajar Hafalan Ananda pada hari ini ({tanggal}):\n- Hafalan: {nama_hafalan} ({kategori})\n- Keterangan: {keterangan} (Petugas: {nama_petugas})\n\nLihat riwayat perkembangan kartu prestasi Ananda secara lengkap pada tautan berikut:\n{link_prestasi}\n\nTerima kasih atas perhatiannya.\n\n*_Wassalamu'alaikum wr. wb._*"
        ];

        foreach ($defaultTemplates as $key => $defaultVal) {
            WaTemplate::firstOrCreate(
                ['key' => $key],
                ['template' => $defaultVal]
            );
        }

        // Auto-update existing koin_scan template if it doesn't contain {nama_petugas}
        $koinScanTemplate = WaTemplate::where('key', 'koin_scan')->first();
        if ($koinScanTemplate && !str_contains($koinScanTemplate->template, '{nama_petugas}')) {
            $newTemplate = str_replace(
                'oleh petugas pada tanggal',
                'oleh petugas *{nama_petugas}* pada tanggal',
                $koinScanTemplate->template
            );
            if (!str_contains($newTemplate, '{nama_petugas}')) {
                $newTemplate = str_replace(
                    'oleh petugas',
                    'oleh petugas *{nama_petugas}*',
                    $koinScanTemplate->template
                );
            }
            $koinScanTemplate->update(['template' => $newTemplate]);
        }

        $templates = WaTemplate::all();
        $pengumumanList = Pengumuman::latest()->get();

        return view('settings.index', compact('user', 'hakakses', 'setting', 'templates', 'pengumumanList'));
    }

    /**
     * Update the settings in database.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'fonnte_token' => 'nullable|string|max:1000',
            'midtrans_client_id' => 'nullable|string|max:255',
            'midtrans_server_key' => 'nullable|string|max:255',
            'midtrans_environment' => 'required|in:sandbox,production',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->id = 1;
        }

        $setting->fill($validated);
        $setting->save();

        return redirect()->route('settings.index', ['tab' => 'api'])->with('success', 'Kredensial API berhasil diperbarui.');
    }

    /**
     * Update WhatsApp templates in database.
     */
    public function updateTemplates(Request $request)
    {
        $validated = $request->validate([
            'templates' => 'required|array',
            'templates.*.key' => 'required|string|exists:tb_wa_template,key',
            'templates.*.template' => 'required|string|max:2000',
        ]);

        foreach ($validated['templates'] as $item) {
            WaTemplate::where('key', $item['key'])
                ->update(['template' => $item['template']]);
        }

        return redirect()->route('settings.index', ['tab' => 'templates'])->with('success', 'Template WhatsApp berhasil diperbarui.');
    }

    /**
     * Update login background image.
     */
    public function updateLoginBg(Request $request)
    {
        $request->validate([
            'foto_masjid' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->id = 1;
        }

        if ($request->hasFile('foto_masjid')) {
            // Delete old file if exists
            if ($setting->foto_masjid) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->foto_masjid);
            }

            $file = $request->file('foto_masjid');
            $path = $file->store('settings', 'public');
            $setting->foto_masjid = $path;
            $setting->save();
        }

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Foto background login berhasil diperbarui.');
    }

    /**
     * Reset login background image to default.
     */
    public function resetLoginBg()
    {
        $setting = Setting::first();
        if ($setting && $setting->foto_masjid) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->foto_masjid);
            $setting->foto_masjid = null;
            $setting->save();
        }

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Background login telah di-reset ke default.');
    }

    /**
     * Update custom logo.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->id = 1;
        }

        if ($request->hasFile('logo')) {
            // Delete old file if exists
            if ($setting->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->logo);
            }

            $file = $request->file('logo');
            $path = $file->store('settings', 'public');
            $setting->logo = $path;
            $setting->save();
        }

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Logo aplikasi berhasil diperbarui.');
    }

    /**
     * Reset custom logo to default.
     */
    public function resetLogo()
    {
        $setting = Setting::first();
        if ($setting && $setting->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->logo);
            $setting->logo = null;
            $setting->save();
        }

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Logo aplikasi telah di-reset ke default.');
    }

    /**
     * Upload announcement image.
     */
    public function uploadPengumuman(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('pengumuman', 'public');

            Pengumuman::create([
                'image_path' => $path,
                'title' => $request->input('title'),
            ]);
        }

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Gambar pengumuman berhasil diunggah.');
    }

    /**
     * Delete announcement image.
     */
    public function deletePengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        
        // Delete image file from server
        if ($pengumuman->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->image_path);
        }

        $pengumuman->delete();

        return redirect()->route('settings.index', ['tab' => 'login'])->with('success', 'Gambar pengumuman berhasil dihapus.');
    }
}
