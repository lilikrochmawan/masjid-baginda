<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penerimaan - Koin Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4fbf7; }

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
        .card { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 16px rgba(15,60,40,0.07); max-width: 560px; }
        .card h2 { color: #0f4d36; margin-bottom: 18px; font-size: 18px; }
        .alert-success { background: #d1fae5; padding: 10px 14px; border-radius: 8px; margin-bottom: 14px; color: #0f5132; font-size: 13px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input[type=text],
        .form-group input[type=date],
        .form-group input[type=number],
        .form-group select { width: 100%; padding: 11px 12px; border-radius: 8px; border: 1px solid #cfe9dd; background: #f8fffb; color: #114e37; font-size: 14px; }
        .btn-primary { display: inline-block; padding: 11px 24px; border-radius: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; cursor: pointer; font-weight: 700; font-size: 13px; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 20px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .card { max-width: 100%; padding: 16px 14px; }
            .form-group input, .form-group select { font-size: 16px; padding: 12px; }
            .btn-primary { width: 100%; text-align: center; }
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
<a href="{{ route('koin.penerimaan.create') }}" class="active">
                <span class="nav-icon">🧾</span> Penerimaan
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.laporan'))
<a href="{{ route('koin.laporan') }}">
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
        <span class="topbar-brand">Input Penerimaan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Input Penerimaan Kaleng</h1></div>

        <div class="card">
            <h2>Form Penerimaan</h2>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('koin.penerimaan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="keterangan">Keterangan (opsional)</label>
                    <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Penerimaan umum dari donatur">
                </div>
                <div class="form-group">
                    <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
                    <input type="date" id="tanggal_penerimaan" name="tanggal_penerimaan" value="{{ old('tanggal_penerimaan', now()->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah Penerimaan</label>
                    <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                </div>
                <div style="margin-top: 16px;">
                    <button class="btn-primary" type="submit">Simpan</button>
                </div>
            </form>
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
