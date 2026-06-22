<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WaTemplate;
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
            'koin_scan' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Bapak/Ibu *{nama_pemilik}*,\n\nKaleng dengan kode *{kode_kaleng}* ({nama_kaleng}) telah berhasil discan / diambil oleh petugas pada tanggal *{tanggal_ambil}*.\n\nTerima kasih atas infak dan partisipasi Anda dalam program Koin Baginda. Semoga menjadi amal jariyah dan membawa berkah bagi keluarga.\n\n*_Wassalamu'alaikum wr. wb._*"
        ];

        foreach ($defaultTemplates as $key => $defaultVal) {
            WaTemplate::firstOrCreate(
                ['key' => $key],
                ['template' => $defaultVal]
            );
        }

        $templates = WaTemplate::all();

        return view('settings.index', compact('user', 'hakakses', 'setting', 'templates'));
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
}
