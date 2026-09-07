<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Baginda</title>
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
        .filters { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; margin-bottom: 20px; }
        .filters label { color: #164a3f; font-weight: 600; font-size: 13px; display: flex; flex-direction: column; gap: 6px; }
        .filters select, .filters input { padding: 10px 12px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 14px; background: #fbfffe; }
        .filters button { padding: 10px 16px; border-radius: 10px; border: none; background: #10b981; color: white; cursor: pointer; font-weight: 600; font-size: 13px; transition: opacity 0.2s; }
        .filters button:hover { opacity: 0.85; }
        .print-button { background: #0f766e; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 16px; }
        .summary-card { background: #effff6; padding: 14px 12px; border-radius: 12px; }
        .summary-card span { display: block; font-size: 11px; color: #166534; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .4px; }
        .summary-card strong { display: block; font-size: 26px; font-weight: 700; color: #064e3b; }
        .kop-header { display: flex; align-items: center; gap: 18px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #d1e7dd; }
        .kop-logo { width: 72px; height: 72px; border-radius: 16px; background: #f3faf7; display: flex; align-items: center; justify-content: center; border: 1px solid #d1e7dd; }
        .kop-logo-img { width: 72px; height: 72px; object-fit: cover; border-radius: 16px; border: 1px solid #d1e7dd; }
        .kop-text { line-height: 1.3; }
        .kop-text .kop-title { font-size: 18px; font-weight: 800; color: #0f4d36; }
        .kop-text .kop-subtitle { font-size: 14px; color: #164a3f; }
        .kop-text .kop-address { font-size: 12px; color: #475057; }
        .kop-report-title { margin-top: 14px; font-size: 16px; font-weight: 700; color: #0f4d36; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            .filters { flex-direction: column; align-items: stretch; }
            .filters button { width: 100%; }
            th, td { padding: 10px 8px; font-size: 12px; }
        }
        @media print {
            .sidebar, .topbar, .sidebar-overlay, .filters, .print-button { display: none !important; }
            .main { margin-left: 0; padding: 0; }
            body { background: white; }
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
            <a href="{{ route('keuangan.laporan') }}" class="active">
                <span class="nav-icon">📊</span> Laporan
            </a>
            @endif
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
        <span class="topbar-brand">Laporan Keuangan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="kop-header">
            <div class="kop-logo">
                    <img src="{{ asset('images/image.png') }}" alt="Masjid Baginda" class="kop-logo-img">
            </div>
            <div class="kop-text">
                <div class="kop-title">MASJID BAGINDA</div>
                <div class="kop-subtitle">Alamat: Perum Taman Harmoni Jeruk Sawit, Gondangrejo, Karanganyar</div>          
            </div>
        </div>
        <div class="page-title"><h1>Laporan Keuangan {{ $periodeLabel }} </h1></div>

        <div class="section">
            <form class="filters" action="{{ route('keuangan.laporan') }}" method="GET">
                <label>
                    Periode
                    <select name="periode">
                        <option value="daily"   {{ $periode === 'daily'   ? 'selected' : '' }}>Harian</option>
                        <option value="weekly"  {{ $periode === 'weekly'  ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ $periode === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </label>
                <label>
                    Tanggal referensi
                    <input type="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}">
                </label>
                <button type="submit">Tampilkan</button>
                <button type="button" class="print-button" onclick="window.print()">🖨️ Cetak</button>
            </form>

            <div class="summary-grid">
                <div class="summary-card">
                    <span>Total Kas Masuk</span>
                    <strong>{{ $totalMasuk }}</strong>
                </div>
                <div class="summary-card">
                    <span>Total Kas Keluar</span>
                    <strong>{{ $totalKeluar }}</strong>
                </div>
                <div class="summary-card">
                    <span>Saldo Keseluruhan</span>
                    <strong>{{ $overallNet }}</strong>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Referensi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasEntries as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_kas }}</td>
                                <td>{{ ucfirst($item->tipe) }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->penerimaanKaleng?->tanggal_penerimaan ? 'Penerimaan ' . $item->penerimaanKaleng->tanggal_penerimaan : '-' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }
    </script>
</body>
</html>
