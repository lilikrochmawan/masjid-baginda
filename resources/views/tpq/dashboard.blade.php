<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TPQ - Baginda</title>
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
        .page-title { margin-bottom: 25px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        .welcome-card { background: white; padding: 24px; border-radius: 14px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); margin-bottom: 25px; border-left: 4px solid #10b981; }
        .welcome-card h2 { font-size: 20px; color: #0f4d36; margin-bottom: 8px; }
        .welcome-card p { font-size: 14px; color: #4b5563; line-height: 1.5; }

        /* ── Stats Grid ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 22px; border-radius: 14px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 50px; height: 50px; border-radius: 12px; background: #e6f7f0; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .stat-details span { display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 4px; }
        .stat-details strong { display: block; font-size: 24px; color: #1f2937; font-weight: 700; }

        /* ── Menu Grid ── */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .menu-card { background: white; padding: 24px; border-radius: 14px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); text-align: center; text-decoration: none; border: 1px solid #e6f4ed; transition: all 0.3s ease; }
        .menu-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(16,185,129,0.12); border-color: #a7f3d0; }
        .menu-card-icon { font-size: 36px; margin-bottom: 12px; display: inline-block; }
        .menu-card h3 { font-size: 16px; color: #0f4d36; margin-bottom: 8px; font-weight: 700; }
        .menu-card p { font-size: 13px; color: #6b7280; line-height: 1.4; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 18px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .stats-grid { gap: 14px; }
            .menu-grid { grid-template-columns: 1fr; gap: 14px; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>📚</span> Manajemen TPQ
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('tpq.dashboard') }}" class="active">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @if(auth()->user()->hasAccess('tpq.guru'))
<a href="{{ route('tpq.guru.index') }}">
                <span class="nav-icon">👨‍🏫</span> Data Guru
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.kelas'))
<a href="{{ route('tpq.kelas.index') }}">
                <span class="nav-icon">🏫</span> Data Kelas
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.santri'))
            <a href="{{ route('tpq.santri.index') }}">
                <span class="nav-icon">🧑‍🎓</span> Data Santri
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.absensi'))
<a href="{{ route('tpq.absensi.index') }}">
                <span class="nav-icon">📝</span> Absensi Santri
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.laporan'))
<a href="{{ route('tpq.laporan.index') }}">
                <span class="nav-icon">📊</span> Laporan Absen
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.keuangan'))
            <a href="{{ route('tpq.keuangan.spp.index') }}" class="{{ request()->routeIs('tpq.keuangan.*') ? 'active' : '' }}">
                <span class="nav-icon">💰</span> Keuangan TPQ
            </a>
            @endif
            <div class="divider"></div>
            <a href="{{ route('dashboard') }}">
                <span class="nav-icon">⬅️</span> Dashboard Utama
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
        <span class="topbar-brand">TPQ Baginda</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Beranda Manajemen TPQ</h1>
        </div>

        <div class="welcome-card">
            <h2>Selamat Datang di Portal TPQ Masjid Baginda! 👋</h2>
            <p>Portal ini digunakan untuk mengelola data guru, pendaftaran kelas, pencatatan data santri, serta perekaman absensi harian dan laporannya secara sistematis.</p>
        </div>

        <!-- Stats Section -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👨‍🏫</div>
                <div class="stat-details">
                    <span>Total Guru</span>
                    <strong>{{ $totalGuru }}</strong>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏫</div>
                <div class="stat-details">
                    <span>Total Kelas</span>
                    <strong>{{ $totalKelas }}</strong>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🧑‍🎓</div>
                <div class="stat-details">
                    <span>Total Santri</span>
                    <strong>{{ $totalSantri }}</strong>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📈</div>
                <div class="stat-details">
                    <span>Hadir Hari Ini</span>
                    <strong>{{ $persentaseHadir }}%</strong>
                </div>
            </div>
        </div>

        <!-- Menu Navigation Grid -->
        <div class="menu-grid">
            @if(auth()->user()->hasAccess('tpq.guru'))
<a href="{{ route('tpq.guru.index') }}" class="menu-card">
                <span class="menu-card-icon">👨‍🏫</span>
                <h3>Data Guru</h3>
                <p>Kelola data pengajar TPQ dan kaitkan dengan akun login mereka.</p>
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.kelas'))
<a href="{{ route('tpq.kelas.index') }}" class="menu-card">
                <span class="menu-card-icon">🏫</span>
                <h3>Data Kelas</h3>
                <p>Kelola daftar kelas dan tentukan guru pengampu/wali kelas masing-masing.</p>
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.santri'))
<a href="{{ route('tpq.santri.index') }}" class="menu-card">
                <span class="menu-card-icon">🧑‍🎓</span>
                <h3>Data Santri</h3>
                <p>Kelola database santri terdaftar dan hubungkan dengan kelas mereka.</p>
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.absensi'))
<a href="{{ route('tpq.absensi.index') }}" class="menu-card">
                <span class="menu-card-icon">📝</span>
                <h3>Absensi Santri</h3>
                <p>Catat kehadiran harian santri. Guru pengampu hanya bisa mengabsen kelasnya.</p>
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.laporan'))
<a href="{{ route('tpq.laporan.index') }}" class="menu-card">
                <span class="menu-card-icon">📊</span>
                <h3>Laporan Kehadiran</h3>
                <p>Lihat rekap persentase absensi mingguan, bulanan, dan tahunan per kelas.</p>
            </a>
@endif
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
