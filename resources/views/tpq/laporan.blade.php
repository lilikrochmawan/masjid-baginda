<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi TPQ - Baginda</title>
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
        
        .filter-row { display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; margin-bottom: 20px; }
        .filter-group { flex: 1; min-width: 180px; }
        .filter-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .filter-group select, .filter-group input { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 700px; }
        th, td { padding: 10px 8px; border: 1px solid #e6f4ed; text-align: center; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }
        
        td.student-name, th.student-name { text-align: left; padding-left: 12px; font-weight: 600; min-width: 180px; }
        
        /* ── Status Colors ── */
        .cell-status { font-weight: 700; font-size: 12px; display: block; width: 24px; height: 24px; line-height: 24px; border-radius: 6px; margin: 0 auto; }
        .status-H { background: #dcfce7; color: #15803d; }
        .status-S { background: #fef9c3; color: #a16207; }
        .status-I { background: #dbeafe; color: #1d4ed8; }
        .status-A { background: #fee2e2; color: #b91c1c; }
        .status-none { color: #9ca3af; }

        .legend { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 18px; font-size: 12.5px; }
        .legend-item { display: flex; align-items: center; gap: 6px; font-weight: 600; color: #4b5563; }
        .legend-color { width: 16px; height: 16px; border-radius: 4px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            .filter-group { min-width: 100%; }
            th, td { padding: 8px 6px; font-size: 12px; }
        }

        /* ── Print Button & Print Layout ── */
        .btn-print { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px; transition: background 0.2s, transform 0.1s; text-decoration: none; }
        .btn-print:hover { background: #059669; transform: translateY(-1px); }
        .btn-print:active { transform: translateY(0); }

        @media print {
            body { background: white !important; color: black !important; }
            .sidebar, .topbar, .sidebar-overlay, .filter-section, .btn-print, .legend, .page-title { display: none !important; }
            .main { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
            .section { box-shadow: none !important; padding: 0 !important; margin: 0 !important; border: none !important; }
            .table-wrapper { overflow: visible !important; }
            table { width: 100% !important; border-collapse: collapse !important; min-width: auto !important; }
            th, td { border: 1px solid #ccc !important; padding: 8px 4px !important; font-size: 11px !important; text-align: center !important; color: black !important; }
            td.student-name, th.student-name { text-align: left !important; padding-left: 8px !important; }
            th { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            
            .cell-status { border: 1px solid #bbb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .status-H { background: #e6fdf0 !important; color: #166534 !important; }
            .status-S { background: #fefce8 !important; color: #854d0e !important; }
            .status-I { background: #eff6ff !important; color: #1e40af !important; }
            .status-A { background: #fef2f2 !important; color: #991b1b !important; }
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
<a href="{{ route('tpq.laporan.index') }}" class="active">
                <span class="nav-icon">📊</span> Laporan Absen
            </a>
@endif
            <a href="{{ route('tpq.prestasi.index') }}">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            @if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator')
            <a href="{{ route('tpq.master-hafalan.index') }}">
                <span class="nav-icon">⚙️</span> Master Hafalan
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
        <span class="topbar-brand">Laporan TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Laporan Kehadiran Santri</h1>
        </div>

        <!-- Filter Form -->
        <div class="section filter-section">
            <form method="GET" action="{{ route('tpq.laporan.index') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="periode">Periode Laporan</label>
                        <select id="periode" name="periode" onchange="this.form.submit()">
                            <option value="weekly" {{ $periode === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ $periode === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ $periode === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="tb_kelas_id">Pilih Kelas</label>
                        <select id="tb_kelas_id" name="tb_kelas_id" onchange="this.form.submit()">
                            @forelse($classes as $c)
                                <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama_kelas }}
                                </option>
                            @empty
                                <option value="">Belum ada kelas</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="tanggal">Pilih Tanggal Rujukan</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ $selectedDate->toDateString() }}" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        <!-- Report Table Section -->
        @if($selectedClassId)
            <div class="section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; flex-wrap:wrap; gap:10px;">
                    <h2>
                        Rekapitulasi Kehadiran - 
                        @if($periode === 'weekly')
                            Mingguan (Minggu Ke-{{ $selectedDate->weekOfYear }}, {{ $selectedDate->year }})
                        @elseif($periode === 'monthly')
                            Bulanan ({{ $selectedDate->format('F Y') }})
                        @else
                            Tahunan (Tahun {{ $selectedDate->year }})
                        @endif
                    </h2>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <span style="font-weight:600; color:#0f766e; background:#e6f7f0; padding:6px 12px; border-radius:8px;">
                            Kelas: {{ $classes->firstWhere('id', $selectedClassId)?->nama_kelas }}
                        </span>
                        <button type="button" onclick="window.print()" class="btn-print">
                            <span>🖨️</span> Cetak Laporan
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th class="student-name">Nama Santri</th>
                                
                                @if($periode === 'weekly' || $periode === 'monthly')
                                    @foreach($dates as $date)
                                        <th style="min-width: 40px; font-size:11px;">
                                            {{ date('d', strtotime($date)) }}<br>
                                            <span style="font-size:9px; color:#6b7280;">{{ date('D', strtotime($date)) }}</span>
                                        </th>
                                    @endforeach
                                @elseif($periode === 'yearly')
                                    @foreach($months as $mNum => $mName)
                                        <th style="min-width: 55px; font-size:11px;">{{ substr($mName, 0, 3) }}</th>
                                    @endforeach
                                @endif
                                
                                <th style="width: 80px; font-weight: 700; background:#f0fdf4;">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($matrix as $santriId => $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="student-name">{{ $row['santri']->nama_santri }}</td>
                                    
                                    @if($periode === 'weekly' || $periode === 'monthly')
                                        @foreach($dates as $date)
                                            @php $status = $row['attendance'][$date]; @endphp
                                            <td>
                                                @if($status !== '-')
                                                    <span class="cell-status status-{{ $status }}">{{ $status }}</span>
                                                @else
                                                    <span class="status-none">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @elseif($periode === 'yearly')
                                        @foreach($months as $mNum => $mName)
                                            @php $percentage = $row['attendance'][$mNum]; @endphp
                                            <td style="font-size: 11.5px; font-weight:600;">
                                                {{ $percentage }}
                                            </td>
                                        @endforeach
                                    @endif
                                    
                                    <td style="font-weight: 700; background:#f9fefb; color:#0f766e;">{{ $row['summary'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($dates) + count($months) + 3 }}" style="text-align:center; color:#9ca3af; padding: 30px 0;">Belum ada santri atau data absensi pada filter terpilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Legend of Status -->
                @if($periode === 'weekly' || $periode === 'monthly')
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-color status-H" style="width:16px; height:16px;"></div>
                            <span>H: Hadir</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color status-S" style="width:16px; height:16px;"></div>
                            <span>S: Sakit</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color status-I" style="width:16px; height:16px;"></div>
                            <span>I: Izin</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color status-A" style="width:16px; height:16px;"></div>
                            <span>A: Alpa</span>
                        </div>
                        <div class="legend-item">
                            <span style="color:#9ca3af; font-weight:700;">- : Belum diabsen</span>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="section">
                <p style="text-align:center; color:#9ca3af; padding: 20px 0;">Silakan pilih kelas dan pastikan kelas memiliki santri untuk melihat rekapitulasi laporan.</p>
            </div>
        @endif
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
