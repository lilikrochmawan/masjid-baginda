<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3faf7; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; height: 100vh; background: linear-gradient(180deg, #059669 0%, #047857 100%); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 200; transition: transform 0.3s ease; overflow-y: auto; }
        .sidebar-brand { padding: 22px 20px 18px; font-size: 18px; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .sidebar-brand span { font-size: 22px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; width: 100%; padding: 11px 20px; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 13.5px; font-weight: 500; transition: background 0.2s, color 0.2s; }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.12); color: white; }
        .sidebar-nav a.active { background: rgba(255,255,255,0.18); color: white; font-weight: 600; border-left: 3px solid white; }
        .sidebar-nav .nav-icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-nav .divider { height: 1px; background: rgba(255,255,255,0.1); margin: 8px 16px; }
        .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,0.15); flex-shrink: 0; }
        .sidebar-footer form { margin: 0; }
        .sidebar-footer button { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.12); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; transition: background 0.2s; }
        .sidebar-footer button:hover { background: rgba(255,255,255,0.22); }

        /* ── Topbar (mobile) ── */
        .topbar { display: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 14px 16px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 150; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .topbar-brand { font-size: 18px; font-weight: 700; }
        .topbar-toggle { background: none; border: none; color: white; font-size: 24px; cursor: pointer; padding: 4px; line-height: 1; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 190; }
        .sidebar-overlay.open { display: block; }

        /* ── Main content ── */
        .main { margin-left: 220px; min-height: 100vh; padding: 28px 28px 40px; }
        .page-title { margin-bottom: 20px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); margin-bottom: 20px; }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: 1.2fr .8fr; gap: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .disabled-select { pointer-events: none; opacity: 0.65; }
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; }
        .button-primary:hover { transform: translateY(-1px); }
        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 14px; }
        .summary-card { background: #effff6; padding: 14px 12px; border-radius: 12px; }
        .summary-card span { display: block; font-size: 11px; color: #166534; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .4px; }
        .summary-card strong { display: block; font-size: 24px; font-weight: 700; color: #064e3b; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }
        .confirm-button { padding: 8px 12px; border-radius: 8px; border: none; background: #0f766e; color: white; cursor: pointer; font-size: 12px; }
        .confirm-button:hover { opacity: 0.9; }

        @media (max-width: 1024px) { .grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            th, td { padding: 10px 8px; font-size: 12px; }
        }
        
        .kop-header { display: none; align-items: center; gap: 18px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #d1e7dd; }
        .kop-logo { width: 72px; height: 72px; border-radius: 16px; background: #f3faf7; display: flex; align-items: center; justify-content: center; border: 1px solid #d1e7dd; }
        .kop-logo-img { width: 72px; height: 72px; object-fit: cover; border-radius: 16px; border: 1px solid #d1e7dd; }
        .kop-text { line-height: 1.3; }
        .kop-text .kop-title { font-size: 18px; font-weight: 800; color: #0f4d36; }
        .kop-text .kop-subtitle { font-size: 14px; color: #164a3f; }
        .kop-text .kop-address { font-size: 12px; color: #475057; }

        @media print {
            .sidebar, .topbar, .sidebar-overlay, .button-primary, .alert, .print-hide { display: none !important; }
            .main { margin-left: 0; padding: 0; }
            body { background: white; }
            .kop-header { display: flex !important; }
            .grid { display: block; }
            .section { box-shadow: none; padding: 0; margin-bottom: 30px; border: none; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>💰</span> Keuangan
        </div>
        <nav class="sidebar-nav">
            @if(auth()->user()->hasAccess('keuangan.transaksi'))
            <a href="{{ route('keuangan.index') }}">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @endif
            @if(auth()->user()->hasAccess('keuangan.laporan'))
            <a href="{{ route('keuangan.laporan') }}">
                <span class="nav-icon">📊</span> Laporan
            </a>
            @endif
            <a href="{{ route('keuangan.event.index') }}" class="active">
                <span class="nav-icon">🎉</span> Keuangan Event
            </a>
            <div class="divider"></div>
            @if(auth()->user()->hasAccess('koin'))
            <a href="{{ route('koin.index') }}">
                <span class="nav-icon">🥫</span> Koin Baginda
            </a>
            @endif
            <a href="{{ route('dashboard') }}">
                <span class="nav-icon">⬅️</span> Dashboard
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><span>🚪</span> Logout</button>
            </form>
        </div>
    </aside>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Topbar (mobile only) -->
    <div class="topbar">
        <span class="topbar-brand">Keuangan Baginda</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="kop-header">
            @php $setting = \App\Models\Setting::first(); @endphp
            <div class="kop-logo">
                @if($setting && $setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Masjid" class="kop-logo-img">
                @else
                    <img src="{{ asset('images/image.png') }}" alt="Logo Masjid" class="kop-logo-img">
                @endif
            </div>
            <div class="kop-text">
                <div class="kop-title">MASJID BAGINDA</div>
                <div class="kop-subtitle">Alamat: Perum Taman Harmoni Jeruk Sawit, Mojorejo, Gondangrejo, Karanganyar</div>          
            </div>
        </div>

        <div class="page-title" style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Keuangan Event: {{ $event->nama_event }}</h1>
            <div>
                <button type="button" class="button-primary" style="background: #0f766e; margin-right: 8px;" onclick="window.print()">🖨️ Cetak</button>
                <a href="{{ route('keuangan.event.index') }}" class="button-primary" style="background: #64748b; text-decoration: none;">&larr; Kembali</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="grid">
            <div class="print-hide">
                <div class="section">
                    <h2>Input Transaksi Event</h2>
                    @if($event->is_transferred)
                        <div class="alert alert-error">Saldo event ini sudah ditransfer ke kas utama masjid. Anda tidak bisa lagi menambah transaksi baru.</div>
                    @else
                        <form action="{{ route('keuangan.event.transaksi.store', $event->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="tanggal_kas">Tanggal</label>
                                <input type="date" id="tanggal_kas" name="tanggal_kas" value="{{ old('tanggal_kas', date('Y-m-d')) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tipe">Tipe Arus Kas</label>
                                <select id="tipe" name="tipe" required>
                                    <option value="">Pilih tipe</option>
                                    <option value="masuk" {{ old('tipe') === 'masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ old('tipe') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                            </div>
                            <button type="submit" class="button-primary">Simpan Transaksi</button>
                        </form>
                    @endif
                </div>
            </div>

            <div>
                <div class="section">
                    <h2>Ringkasan Event</h2>
                    <div class="summary-grid">
                        <div class="summary-card">
                            <span>Total Pemasukan</span>
                            <strong>{{ number_format($totalMasuk, 0, ',', '.') }}</strong>
                        </div>
                        <div class="summary-card">
                            <span>Total Pengeluaran</span>
                            <strong>{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
                        </div>
                        <div class="summary-card" style="{{ $saldo < 0 ? 'background: #fee2e2;' : '' }}">
                            <span>Sisa Saldo</span>
                            <strong style="{{ $saldo < 0 ? 'color: #991b1b;' : '' }}">{{ number_format($saldo, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    
                    <div class="print-hide" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                        <h3>Transfer ke Kas Masjid</h3>
                        <p style="font-size: 13px; color: #4b5563; margin-top: 8px; margin-bottom: 16px;">
                            Jika event ini sudah selesai, Anda bisa mentransfer sisa saldo event ini ke dalam kas operasional utama masjid.
                        </p>
                        @if($event->is_transferred)
                            <div class="badge" style="background:#d1fae5; color:#065f46; padding: 8px 14px;">Sudah ditransfer ke kas utama</div>
                        @else
                            <form action="{{ route('keuangan.event.transfer', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mentransfer sisa saldo Rp {{ number_format($saldo, 0, ',', '.') }} ke kas utama masjid? Setelah ditransfer, data event tidak bisa ditambah/diubah lagi.');">
                                @csrf
                                <button type="submit" class="button-primary" style="width: 100%; {{ $saldo <= 0 ? 'opacity: 0.5; pointer-events: none;' : '' }}">Transfer Saldo (Rp {{ number_format($saldo, 0, ',', '.') }})</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Riwayat Transaksi Event</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah (Rp)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event->transaksis as $trx)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trx->tanggal_kas }}</td>
                                <td>
                                    @if($trx->tipe === 'masuk')
                                        <span class="badge" style="background:#dcfce7; color:#166534;">Masuk</span>
                                    @else
                                        <span class="badge" style="background:#fee2e2; color:#991b1b;">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $trx->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Belum ada transaksi pada event ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }
    </script>
@include('components.global-loader')
</body>
</html>
