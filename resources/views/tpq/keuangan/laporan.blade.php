<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kas TPQ - Baginda</title>
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

        /* ── Navigation Tabs ── */
        .tabs-nav { display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px; overflow-x: auto; }
        .tab-btn { padding: 10px 18px; text-decoration: none; color: #164a3f; font-size: 13.5px; font-weight: 600; border-radius: 8px; background: #eef7f4; transition: all 0.2s ease; white-space: nowrap; }
        .tab-btn:hover { background: #d1e7dd; color: #0f4d36; }
        .tab-btn.active { background: #10b981; color: white; }

        /* ── Filters ── */
        .filters { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; margin-bottom: 20px; }
        .filters label { color: #164a3f; font-weight: 600; font-size: 13px; display: flex; flex-direction: column; gap: 6px; }
        .filters select, .filters input { padding: 10px 12px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 14px; background: #fbfffe; color: #103a2d; outline: none; }
        .filters button { padding: 10px 18px; border-radius: 10px; border: none; background: #10b981; color: white; cursor: pointer; font-weight: 700; font-size: 13.5px; transition: opacity 0.2s; }
        .filters button:hover { opacity: 0.85; }
        .print-btn { background: #0f766e !important; }

        /* ── Summary cards ── */
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .summary-card { background: #effff6; padding: 18px 16px; border-radius: 12px; border: 1px solid #d1e7dd; box-shadow: 0 2px 8px rgba(16,80,40,0.03); }
        .summary-card span { display: block; font-size: 11px; color: #1565c0; color: #166534; font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .5px; }
        .summary-card strong { display: block; font-size: 22px; font-weight: 800; color: #064e3b; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        .badge-masuk { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }
        .badge-keluar { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; }

        /* ── Print Header ── */
        .print-header { display: none; margin-bottom: 24px; border-bottom: 2px solid #000; padding-bottom: 16px; }
        .print-logo-container { display: flex; align-items: center; gap: 16px; }
        .print-logo { width: 68px; height: 68px; border-radius: 12px; object-fit: cover; }
        .print-title { font-size: 20px; font-weight: 800; color: #000; }
        .print-subtitle { font-size: 13px; color: #333; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            .filters { flex-direction: column; align-items: stretch; }
            .filters button { width: 100%; }
        }

        /* ── Print Styles ── */
        @media print {
            .sidebar, .topbar, .sidebar-overlay, .tabs-nav, .filters, .print-btn { display: none !important; }
            .main { margin-left: 0; padding: 0; background: white; }
            .section { box-shadow: none; padding: 0; }
            body { background: white; }
            .print-header { display: block; }
            th { background: #f1f5f9 !important; border-bottom: 2px solid #000 !important; color: #000 !important; }
            td, th { border-bottom: 1px solid #cbd5e1 !important; color: #000 !important; }
            .summary-card { border: 1px solid #cbd5e1 !important; background: none !important; }
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
            <a href="{{ route('tpq.dashboard') }}">
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
            <a href="{{ route('tpq.keuangan.spp.index') }}" class="active">
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
        <span class="topbar-brand">Keuangan TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <!-- Print Header -->
        <div class="print-header">
            <div class="print-logo-container">
                <img src="{{ asset('images/image.png') }}" class="print-logo" alt="Masjid Baginda">
                <div>
                    <div class="print-title">MASJID BAGINDA - LAPORAN KAS TPQ</div>
                    <div class="print-subtitle">Alamat: Perum Taman Harmoni Jeruk Sawit, Gondangrejo, Karanganyar</div>
                </div>
            </div>
        </div>

        <div class="page-title">
            <h1>Keuangan TPQ</h1>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs-nav">
            <a href="{{ route('tpq.keuangan.spp.index') }}" class="tab-btn">Pembayaran SPP</a>
            <a href="{{ route('tpq.keuangan.rekap.index') }}" class="tab-btn">Rekap SPP</a>
            <a href="{{ route('tpq.keuangan.kas.index') }}" class="tab-btn">Arus Kas (Cashflow)</a>
            <a href="{{ route('tpq.keuangan.laporan.index') }}" class="tab-btn active">Laporan Kas</a>
        </div>

        <div class="section">
            <h2>Laporan Kas Operasional TPQ</h2>

            <form class="filters" action="{{ route('tpq.keuangan.laporan.index') }}" method="GET">
                <label>
                    Tanggal Mulai
                    <input type="date" name="start_date" value="{{ $startDate }}" required>
                </label>
                <label>
                    Tanggal Selesai
                    <input type="date" name="end_date" value="{{ $endDate }}" required>
                </label>
                <button type="submit">Tampilkan</button>
                <button type="button" class="print-btn" onclick="window.print()">🖨️ Cetak Laporan</button>
            </form>

            <div class="summary-grid">
                <div class="summary-card">
                    <span>Kas Masuk (SPP)</span>
                    <strong>Rp {{ number_format($totalMasukSpp, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-card">
                    <span>Kas Masuk (Lainnya)</span>
                    <strong>Rp {{ number_format($totalMasukLain, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-card">
                    <span>Total Pengeluaran</span>
                    <strong>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-card" style="background:#eef7f4;">
                    <span>Saldo Akhir Kas</span>
                    <strong>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</strong>
                </div>
            </div>

            <h3 style="color:#0f4d36; font-size:15px; margin-bottom:12px; margin-top:28px;">Rincian Transaksi Kas Periode: {{ date('d/m/Y', strtotime($startDate)) }} s/d {{ date('d/m/Y', strtotime($endDate)) }}</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Pencatat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasEntries as $entry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($entry->tanggal)) }}</td>
                                <td>
                                    <strong>{{ $entry->keterangan }}</strong>
                                    @if($entry->tb_spp_pembayaran_id)
                                        <span style="font-size:10px; color:#0f766e; background:#eef7f4; padding:2px 6px; border-radius:4px; margin-left:6px; font-weight:600;">
                                            SPP Santri
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($entry->tipe === 'masuk')
                                        <span class="badge-masuk">Masuk</span>
                                    @else
                                        <span class="badge-keluar">Keluar</span>
                                    @endif
                                </td>
                                <td><strong>Rp {{ number_format($entry->jumlah, 0, ',', '.') }}</strong></td>
                                <td>{{ $entry->user->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; color:#9ca3af;">Tidak ditemukan transaksi kas pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
