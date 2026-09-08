<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\KoinBagindaController;

Route::get('/', function () {
    return redirect('/login');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/password', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');

    Route::get('/koin-baginda', [KoinBagindaController::class, 'index'])->name('koin.index');
    Route::get('/koin-baginda/inventory', [KoinBagindaController::class, 'inventory'])->name('koin.inventory');
    Route::post('/koin-baginda/inventory', [KoinBagindaController::class, 'storeKaleng'])->name('koin.inventory.store');
    Route::get('/koin-baginda/pemilik', [KoinBagindaController::class, 'pemilik'])->name('koin.pemilik');
    Route::post('/koin-baginda/pemilik', [KoinBagindaController::class, 'storePemilik'])->name('koin.pemilik.store');
    Route::put('/koin-baginda/pemilik/{id}', [KoinBagindaController::class, 'updatePemilik'])->name('koin.pemilik.update');
    Route::get('/koin-baginda/transaksi', [KoinBagindaController::class, 'scan'])->name('koin.scan');
    Route::post('/koin-baginda/transaksi', [KoinBagindaController::class, 'storeTransaction'])->name('koin.scan.store');
    Route::get('/koin-baginda/qr-generator', [KoinBagindaController::class, 'qrGenerator'])->name('koin.qr.generate');
    Route::get('/koin-baginda/laporan', [KoinBagindaController::class, 'laporan'])->name('koin.laporan');
    Route::get('/koin-baginda/laporan/print', [KoinBagindaController::class, 'printLaporan'])->name('koin.laporan.print');
    // Penerimaan kaleng
    Route::get('/koin-baginda/penerimaan', [App\Http\Controllers\PenerimaanKalengController::class, 'create'])->name('koin.penerimaan.create');
    Route::post('/koin-baginda/penerimaan', [App\Http\Controllers\PenerimaanKalengController::class, 'store'])->name('koin.penerimaan.store');

    // Keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::post('/keuangan/{id}/confirm', [KeuanganController::class, 'confirm'])->name('keuangan.confirm');
    Route::get('/keuangan/laporan', [KeuanganController::class, 'laporan'])->name('keuangan.laporan');

    // Pengaturan Sistem
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/templates', [App\Http\Controllers\SettingController::class, 'updateTemplates'])->name('settings.templates.update');
    Route::post('/settings/login-bg', [App\Http\Controllers\SettingController::class, 'updateLoginBg'])->name('settings.login-bg.update');
    Route::post('/settings/login-bg/reset', [App\Http\Controllers\SettingController::class, 'resetLoginBg'])->name('settings.login-bg.reset');
    Route::post('/settings/logo', [App\Http\Controllers\SettingController::class, 'updateLogo'])->name('settings.logo.update');
    Route::post('/settings/logo/reset', [App\Http\Controllers\SettingController::class, 'resetLogo'])->name('settings.logo.reset');
    Route::post('/settings/pengumuman', [App\Http\Controllers\SettingController::class, 'uploadPengumuman'])->name('settings.pengumuman.upload');
    Route::delete('/settings/pengumuman/{id}', [App\Http\Controllers\SettingController::class, 'deletePengumuman'])->name('settings.pengumuman.delete');
    Route::post('/settings/whatsapp-groups', [App\Http\Controllers\SettingController::class, 'waGroupsStore'])->name('settings.wa-groups.store');
    Route::delete('/settings/whatsapp-groups/{id}', [App\Http\Controllers\SettingController::class, 'waGroupsDestroy'])->name('settings.wa-groups.destroy');

    // Modul Data Operasional
    Route::prefix('operasional')->name('operasional.')->group(function () {
        Route::get('/', [App\Http\Controllers\OperasionalController::class, 'dashboard'])->name('dashboard');

        // Struktur Organisasi Takmir
        Route::get('/struktur', [App\Http\Controllers\OperasionalController::class, 'strukturIndex'])->name('struktur.index');
        Route::post('/struktur', [App\Http\Controllers\OperasionalController::class, 'strukturStore'])->name('struktur.store');
        Route::put('/struktur/{id}', [App\Http\Controllers\OperasionalController::class, 'strukturUpdate'])->name('struktur.update');
        Route::delete('/struktur/{id}', [App\Http\Controllers\OperasionalController::class, 'strukturDestroy'])->name('struktur.destroy');

        // Inventarisasi Barang
        Route::get('/inventaris', [App\Http\Controllers\OperasionalController::class, 'inventarisIndex'])->name('inventaris.index');
        Route::post('/jenis-barang', [App\Http\Controllers\OperasionalController::class, 'jenisStore'])->name('jenis.store');
        Route::put('/jenis-barang/{id}', [App\Http\Controllers\OperasionalController::class, 'jenisUpdate'])->name('jenis.update');
        Route::delete('/jenis-barang/{id}', [App\Http\Controllers\OperasionalController::class, 'jenisDestroy'])->name('jenis.destroy');

        Route::post('/barang', [App\Http\Controllers\OperasionalController::class, 'barangStore'])->name('barang.store');
        Route::put('/barang/{id}', [App\Http\Controllers\OperasionalController::class, 'barangUpdate'])->name('barang.update');
        Route::delete('/barang/{id}', [App\Http\Controllers\OperasionalController::class, 'barangDestroy'])->name('barang.destroy');

        Route::post('/inventaris', [App\Http\Controllers\OperasionalController::class, 'inventarisStore'])->name('inventaris.store');
        Route::put('/inventaris/{id}', [App\Http\Controllers\OperasionalController::class, 'inventarisUpdate'])->name('inventaris.update');
        Route::delete('/inventaris/{id}', [App\Http\Controllers\OperasionalController::class, 'inventarisDestroy'])->name('inventaris.destroy');

        // Persuratan
        Route::get('/surat', [App\Http\Controllers\OperasionalController::class, 'suratIndex'])->name('surat.index');
        Route::post('/surat', [App\Http\Controllers\OperasionalController::class, 'suratStore'])->name('surat.store');
        Route::put('/surat/{id}', [App\Http\Controllers\OperasionalController::class, 'suratUpdate'])->name('surat.update');
        Route::delete('/surat/{id}', [App\Http\Controllers\OperasionalController::class, 'suratDestroy'])->name('surat.destroy');

        // Pembuatan Surat Resmi & TTE
        Route::post('/surat-buat', [App\Http\Controllers\OperasionalController::class, 'suratBuatStore'])->name('surat-buat.store');
        Route::put('/surat-buat/{id}', [App\Http\Controllers\OperasionalController::class, 'suratBuatUpdate'])->name('surat-buat.update');
        Route::delete('/surat-buat/{id}', [App\Http\Controllers\OperasionalController::class, 'suratBuatDestroy'])->name('surat-buat.destroy');
        Route::post('/surat-buat/{id}/sign', [App\Http\Controllers\OperasionalController::class, 'suratBuatSign'])->name('surat-buat.sign');
        Route::get('/surat-buat/{id}/print', [App\Http\Controllers\OperasionalController::class, 'suratBuatPrint'])->name('surat-buat.print');
        Route::post('/surat-buat-template', [App\Http\Controllers\OperasionalController::class, 'suratTemplateStore'])->name('surat-buat-template.store');
        Route::post('/edokumen', [App\Http\Controllers\OperasionalController::class, 'edokumenStore'])->name('edokumen.store');
        Route::delete('/edokumen/{id}', [App\Http\Controllers\OperasionalController::class, 'edokumenDestroy'])->name('edokumen.destroy');

        // Broadcast Pengumuman Takmir
        Route::get('/broadcast', [App\Http\Controllers\OperasionalController::class, 'broadcastIndex'])->name('broadcast.index');
        Route::get('/broadcast/wa-groups', [App\Http\Controllers\OperasionalController::class, 'fetchWaGroups'])->name('broadcast.wa-groups');
        Route::post('/broadcast', [App\Http\Controllers\OperasionalController::class, 'broadcastStore'])->name('broadcast.store');
        Route::post('/broadcast-template', [App\Http\Controllers\OperasionalController::class, 'broadcastTemplateStore'])->name('broadcast-template.store');
        Route::put('/broadcast-template/{id}', [App\Http\Controllers\OperasionalController::class, 'broadcastTemplateUpdate'])->name('broadcast-template.update');
        Route::delete('/broadcast-template/{id}', [App\Http\Controllers\OperasionalController::class, 'broadcastTemplateDestroy'])->name('broadcast-template.destroy');

        // Rencana Kerja
        Route::get('/rencana-kerja', [App\Http\Controllers\OperasionalController::class, 'rencanaIndex'])->name('rencana.index');
        Route::post('/rencana-kerja', [App\Http\Controllers\OperasionalController::class, 'rencanaStore'])->name('rencana.store');
        Route::put('/rencana-kerja/{id}', [App\Http\Controllers\OperasionalController::class, 'rencanaUpdate'])->name('rencana.update');
        Route::delete('/rencana-kerja/{id}', [App\Http\Controllers\OperasionalController::class, 'rencanaDestroy'])->name('rencana.destroy');
    });

    // Modul Manajemen TPQ
    Route::prefix('tpq')->name('tpq.')->group(function () {
        Route::get('/', [App\Http\Controllers\TpqController::class, 'dashboard'])->name('dashboard');
        
        // Guru CRUD
        Route::get('/guru', [App\Http\Controllers\TpqController::class, 'guruIndex'])->name('guru.index');
        Route::post('/guru', [App\Http\Controllers\TpqController::class, 'guruStore'])->name('guru.store');
        Route::put('/guru/{id}', [App\Http\Controllers\TpqController::class, 'guruUpdate'])->name('guru.update');
        Route::delete('/guru/{id}', [App\Http\Controllers\TpqController::class, 'guruDestroy'])->name('guru.destroy');
        
        // Kelas CRUD
        Route::get('/kelas', [App\Http\Controllers\TpqController::class, 'kelasIndex'])->name('kelas.index');
        Route::post('/kelas', [App\Http\Controllers\TpqController::class, 'kelasStore'])->name('kelas.store');
        Route::put('/kelas/{id}', [App\Http\Controllers\TpqController::class, 'kelasUpdate'])->name('kelas.update');
        Route::delete('/kelas/{id}', [App\Http\Controllers\TpqController::class, 'kelasDestroy'])->name('kelas.destroy');

        // Santri CRUD
        Route::get('/santri/export/excel', [App\Http\Controllers\TpqController::class, 'santriExportExcel'])->name('santri.export.excel');
        Route::get('/santri/export/pdf', [App\Http\Controllers\TpqController::class, 'santriExportPdf'])->name('santri.export.pdf');
        Route::get('/santri', [App\Http\Controllers\TpqController::class, 'santriIndex'])->name('santri.index');
        Route::post('/santri', [App\Http\Controllers\TpqController::class, 'santriStore'])->name('santri.store');
        Route::put('/santri/{id}', [App\Http\Controllers\TpqController::class, 'santriUpdate'])->name('santri.update');
        Route::delete('/santri/{id}', [App\Http\Controllers\TpqController::class, 'santriDestroy'])->name('santri.destroy');

        // Absensi Santri
        Route::get('/absensi', [App\Http\Controllers\TpqController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [App\Http\Controllers\TpqController::class, 'absensiStore'])->name('absensi.store');
        Route::post('/absensi/send-wa', [App\Http\Controllers\TpqController::class, 'absensiSendWa'])->name('absensi.send-wa');

        // Laporan Absensi
        Route::get('/laporan', [App\Http\Controllers\TpqController::class, 'laporanIndex'])->name('laporan.index');

        // Master Hafalan CRUD
        Route::prefix('master-hafalan')->name('master-hafalan.')->group(function () {
            Route::get('/', [App\Http\Controllers\TpqMasterHafalanController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\TpqMasterHafalanController::class, 'store'])->name('store');
            Route::put('/{id}', [App\Http\Controllers\TpqMasterHafalanController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TpqMasterHafalanController::class, 'destroy'])->name('destroy');
        });

        // Kartu Prestasi
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/', [App\Http\Controllers\TpqPrestasiController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\TpqPrestasiController::class, 'store'])->name('store');
            Route::delete('/{id}', [App\Http\Controllers\TpqPrestasiController::class, 'destroy'])->name('destroy');
            Route::get('/last-progress', [App\Http\Controllers\TpqPrestasiController::class, 'getLastProgress'])->name('last-progress');
        });

        // Keuangan TPQ
        Route::prefix('keuangan')->name('keuangan.')->group(function () {
            // SPP Pembayaran
            Route::get('/spp', [App\Http\Controllers\TpqKeuanganController::class, 'sppIndex'])->name('spp.index');
            Route::post('/spp', [App\Http\Controllers\TpqKeuanganController::class, 'sppStore'])->name('spp.store');
            Route::post('/spp/{id}/broadcast', [App\Http\Controllers\TpqKeuanganController::class, 'sppBroadcast'])->name('spp.broadcast');

            // Rekap SPP
            Route::get('/rekap-spp', [App\Http\Controllers\TpqKeuanganController::class, 'rekapIndex'])->name('rekap.index');

            // Kas Operasional
            Route::get('/kas', [App\Http\Controllers\TpqKeuanganController::class, 'kasIndex'])->name('kas.index');
            Route::post('/kas', [App\Http\Controllers\TpqKeuanganController::class, 'kasStore'])->name('kas.store');

            // Laporan Kas
            Route::get('/laporan-kas', [App\Http\Controllers\TpqKeuanganController::class, 'laporanIndex'])->name('laporan.index');
        });
    });
});

// Route Publik Tanpa Login (Wali Santri & Verifikasi TTE)
Route::get('/tpq/prestasi/santri/{token}', [App\Http\Controllers\TpqPrestasiController::class, 'publicShow'])->name('tpq.prestasi.public');
Route::get('/verifikasi-tte/{id}', [App\Http\Controllers\OperasionalController::class, 'tteVerify'])->name('tte.verify');

