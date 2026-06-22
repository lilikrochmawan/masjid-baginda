<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Operasional - Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3faf7; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; height: 100vh; background: linear-gradient(180deg, #059669 0%, #047857 100%); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 200; transition: transform 0.3s ease; overflow-y: auto; }
        .sidebar-brand { padding: 22px 20px 18px; font-size: 16px; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
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
        .page-title { margin-bottom: 24px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 24px; border-radius: 16px; box-shadow: 0 4px 20px rgba(16,185,129,0.06); display: flex; align-items: center; justify-content: space-between; border: 1px solid rgba(16,185,129,0.08); transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(16,185,129,0.12); }
        .card-info h3 { font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .card-info .value { font-size: 28px; font-weight: 700; color: #0f172a; }
        .card-icon { font-size: 32px; background: #e6f4ed; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; color: #10b981; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .section { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(16,185,129,0.06); border: 1px solid rgba(16,185,129,0.08); }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }

        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .list-item:last-child { border-bottom: none; }
        .list-item-title { font-weight: 600; color: #334155; font-size: 14px; }
        .list-item-desc { font-size: 12px; color: #64748b; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-info { background: #dcfce7; color: #0f766e; }
        .badge-warning { background: #fef3c7; color: #d97706; }

        .module-links { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 30px; }
        .module-link-btn { display: flex; align-items: center; gap: 12px; background: white; border: 1px solid #e2e8f0; padding: 16px; border-radius: 12px; text-decoration: none; color: #1e293b; font-weight: 600; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .module-link-btn:hover { background: #f8fafc; border-color: #10b981; transform: translateY(-1px); }
        .module-link-icon { font-size: 24px; }

        @media (max-width: 1024px) { .info-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>📋</span> Data Operasional
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('operasional.dashboard') }}" class="active">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @if(auth()->user()->hasAccess('operasional.struktur'))
            <a href="{{ route('operasional.struktur.index') }}">
                <span class="nav-icon">👥</span> Struktur Takmir
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.inventaris'))
            <a href="{{ route('operasional.inventaris.index') }}">
                <span class="nav-icon">🥫</span> Inventarisasi Barang
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.surat'))
            <a href="{{ route('operasional.surat.index') }}">
                <span class="nav-icon">✉️</span> Surat & Proposal
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.rencana'))
            <a href="{{ route('operasional.rencana.index') }}">
                <span class="nav-icon">📅</span> Rencana Kerja
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
        <span class="topbar-brand">Data Operasional</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Beranda Data Operasional</h1>
        </div>

        <!-- Cards -->
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-info">
                    <h3>Pengurus Takmir</h3>
                    <div class="value">{{ $aktifTakmir }} <span style="font-size:14px; color:#64748b; font-weight:normal;">Aktif</span></div>
                </div>
                <div class="card-icon" style="background:#e6f4ed; color:#10b981;">👥</div>
            </div>
            <div class="card">
                <div class="card-info">
                    <h3>Total Unit Aset</h3>
                    <div class="value">{{ $totalInventaris }} <span style="font-size:14px; color:#64748b; font-weight:normal;">Unit</span></div>
                </div>
                <div class="card-icon" style="background:#fef3c7; color:#d97706;">🥫</div>
            </div>
            <div class="card">
                <div class="card-info">
                    <h3>Proposal & Surat</h3>
                    <div class="value">{{ $totalSurat }} <span style="font-size:14px; color:#64748b; font-weight:normal;">Dokumen</span></div>
                </div>
                <div class="card-icon" style="background:#dcfce7; color:#15803d;">✉️</div>
            </div>
            <div class="card">
                <div class="card-info">
                    <h3>Rencana Kerja</h3>
                    <div class="value">{{ $totalRencana }} <span style="font-size:14px; color:#64748b; font-weight:normal;">Program</span></div>
                </div>
                <div class="card-icon" style="background:#f3e8ff; color:#7e22ce;">📅</div>
            </div>
        </div>

        <div class="info-grid">
            <!-- Left Column: Inventaris Status -->
            <div class="section">
                <h2>Ringkasan Kondisi Aset</h2>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Kondisi Baik</div>
                        <div class="list-item-desc">Aset operasional layak pakai</div>
                    </div>
                    <span class="badge badge-success">{{ $kondisiBaik }} Unit</span>
                </div>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Kondisi Rusak (Ringan/Berat)</div>
                        <div class="list-item-desc">Aset butuh perbaikan / diganti</div>
                    </div>
                    <span class="badge badge-warning">{{ $kondisiRusak }} Unit</span>
                </div>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Total Jenis Barang</div>
                        <div class="list-item-desc">Kategori master barang terdaftar</div>
                    </div>
                    <span class="badge badge-info">{{ $totalBarang }} Jenis</span>
                </div>
            </div>

            <!-- Right Column: Rencana Kerja & Dokumen -->
            <div class="section">
                <h2>Ringkasan Surat & Rencana</h2>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Surat Masuk / Keluar</div>
                        <div class="list-item-desc">Arsip korespondensi operasional</div>
                    </div>
                    <span class="badge badge-info">{{ $suratMasuk + $suratKeluar }} Berkas</span>
                </div>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Proposal Kegiatan</div>
                        <div class="list-item-desc">Proposal aktif yang diajukan</div>
                    </div>
                    <span class="badge badge-warning">{{ $proposal }} Proposal</span>
                </div>
                <div class="list-item">
                    <div>
                        <div class="list-item-title">Program Sedang Berjalan</div>
                        <div class="list-item-desc">Rencana kerja seksi saat ini</div>
                    </div>
                    <span class="badge badge-success">{{ $rencanaJalan }} Aktif</span>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <h2 style="font-size:18px; color:#0f4d36; margin-top:35px; margin-bottom:15px;">Akses Cepat Submodul</h2>
        <div class="module-links">
            @if(auth()->user()->hasAccess('operasional.struktur'))
            <a href="{{ route('operasional.struktur.index') }}" class="module-link-btn">
                <span class="module-link-icon">👥</span>
                <span>Struktur Organisasi Takmir</span>
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.inventaris'))
            <a href="{{ route('operasional.inventaris.index') }}" class="module-link-btn">
                <span class="module-link-icon">🥫</span>
                <span>Inventarisasi Barang</span>
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.surat'))
            <a href="{{ route('operasional.surat.index') }}" class="module-link-btn">
                <span class="module-link-icon">✉️</span>
                <span>Administrasi Persuratan</span>
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.rencana'))
            <a href="{{ route('operasional.rencana.index') }}" class="module-link-btn">
                <span class="module-link-icon">📅</span>
                <span>Rencana Kerja Seksi</span>
            </a>
            @endif
        </div>
    </main>

    <script>
        // Sidebar Toggle
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
