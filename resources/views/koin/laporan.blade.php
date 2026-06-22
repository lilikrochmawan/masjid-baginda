<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Koin Baginda</title>
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
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 16px; }
        .summary-card { background: #effff6; padding: 14px 12px; border-radius: 12px; }
        .summary-card span { display: block; font-size: 11px; color: #166534; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .4px; }
        .summary-card strong { display: block; font-size: 28px; font-weight: 700; color: #064e3b; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 20px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            th, td { padding: 10px 8px; font-size: 12px; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>🥫</span> Koin Baginda
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('koin.index') }}">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @if(auth()->user()->hasAccess('koin.inventory'))
<a href="{{ route('koin.inventory') }}">
                <span class="nav-icon">📦</span> Inventori
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.pemilik'))
<a href="{{ route('koin.pemilik') }}">
                <span class="nav-icon">👤</span> Pemilik
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.scan'))
<a href="{{ route('koin.scan') }}">
                <span class="nav-icon">📷</span> Scan
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.penerimaan'))
<a href="{{ route('koin.penerimaan.create') }}">
                <span class="nav-icon">🧾</span> Penerimaan
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.laporan'))
<a href="{{ route('koin.laporan') }}" class="active">
                <span class="nav-icon">📊</span> Laporan
            </a>
@endif
            <div class="divider"></div>
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
        <span class="topbar-brand">Laporan Koin</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Laporan Koin Baginda</h1></div>

        <div class="section">
            <h2>1. Laporan Kaleng Bulan Ini</h2>
            <div class="summary-grid">
                <div class="summary-card">
                    <span>Sudah discan bulan ini</span>
                    <strong>{{ $kalengSudah->count() }}</strong>
                </div>
                <div class="summary-card">
                    <span>Belum discan bulan ini</span>
                    <strong>{{ $kalengBelum->count() }}</strong>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Kaleng</th>
                            <th>Nama Kaleng</th>
                            <th>Pemilik</th>
                            <th>Alamat Pemilik</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kalengSudah as $kaleng)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kaleng->kode_kaleng }}</td>
                                <td>{{ $kaleng->nama_kaleng }}</td>
                                <td>{{ $kaleng->latestPemilik?->nama ?? '-' }}</td>
                                <td>{{ $kaleng->latestPemilik?->alamat ?? '-' }}</td>
                                <td><span class="badge">Sudah Scan</span></td>
                            </tr>
                        @endforeach
                        @foreach($kalengBelum as $kaleng)
                            <tr>
                                <td>{{ $kalengSudah->count() + $loop->iteration }}</td>
                                <td>{{ $kaleng->kode_kaleng }}</td>
                                <td>{{ $kaleng->nama_kaleng }}</td>
                                <td>{{ $kaleng->latestPemilik?->nama ?? '-' }}</td>
                                <td>{{ $kaleng->latestPemilik?->alamat ?? '-' }}</td>
                                <td><span class="badge" style="background:#fef3c7;color:#92400e;">Belum Scan</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>2. Laporan Pemasukan Kaleng Global</h2>
            <div class="summary-grid">
                <div class="summary-card">
                    <span>Total Penerimaan</span>
                    <strong>{{ $totalPenerimaan }}</strong>
                </div>
                <div class="summary-card">
                    <span>Jumlah catatan</span>
                    <strong>{{ $penerimaan->count() }}</strong>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>User Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penerimaan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal_penerimaan)->format('d M Y') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>{{ $item->user?->nama ?? '-' }}</td>
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
