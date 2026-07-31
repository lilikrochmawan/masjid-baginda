<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran SPP TPQ - Baginda</title>
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
        .filters button { padding: 10px 16px; border-radius: 10px; border: none; background: #10b981; color: white; cursor: pointer; font-weight: 600; font-size: 13px; transition: opacity 0.2s; }
        .filters button:hover { opacity: 0.85; }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 1000px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        /* ── Payment Badges ── */
        .status-paid { display: inline-flex; align-items: center; justify-content: center; padding: 6px 10px; border-radius: 8px; background: #d1fae5; color: #0f5132; font-size: 11px; font-weight: 700; border: 1px solid #a7f3d0; text-decoration: none; cursor: default; }
        .btn-pay { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-pay:hover { background: #e2e8f0; color: #0f172a; border-color: #94a3b8; }

        /* ── Modal ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 24px; width: 100%; max-width: 450px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); animation: scaleUp 0.2s ease-out; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #edf2f7; padding-bottom: 12px; }
        .modal-header h3 { color: #0f4d36; font-size: 18px; }
        .modal-close { background: none; border: none; font-size: 20px; cursor: pointer; color: #a0aec0; }
        .modal-body { margin-bottom: 20px; }
        
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; outline: none; }
        .form-group input[readonly] { background: #eef7f4; color: #5c7b73; cursor: not-allowed; border-color: #c3e2d5; }

        @keyframes scaleUp { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }

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
            <a href="{{ route('tpq.prestasi.index') }}">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            @if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator')
            <a href="{{ route('tpq.master-hafalan.index') }}">
                <span class="nav-icon">⚙️</span> Master Hafalan
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
        <div class="page-title">
            <h1>Keuangan TPQ</h1>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs-nav">
            <a href="{{ route('tpq.keuangan.spp.index') }}" class="tab-btn active">Pembayaran SPP</a>
            <a href="{{ route('tpq.keuangan.rekap.index') }}" class="tab-btn">Rekap SPP</a>
            <a href="{{ route('tpq.keuangan.kas.index') }}" class="tab-btn">Arus Kas (Cashflow)</a>
            <a href="{{ route('tpq.keuangan.laporan.index') }}" class="tab-btn">Laporan Kas</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section">
            <h2>Peta Pembayaran SPP Tahun {{ $year }}</h2>

            <form class="filters" action="{{ route('tpq.keuangan.spp.index') }}" method="GET">
                <label>
                    Tahun
                    <select name="year">
                        @for($y = date('Y') - 3; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </label>
                <label>
                    Filter Kelas
                    <select name="kelas_id" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit">Tampilkan</button>
            </form>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Kelas</th>
                            @for($m = 1; $m <= 12; $m++)
                                <th>{{ substr(\Carbon\Carbon::create()->month($m)->format('F'), 0, 3) }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santris as $santri)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $santri->nis ?? '-' }}</td>
                                <td><strong>{{ $santri->nama_santri }}</strong></td>
                                <td>
                                    @if($santri->kelas)
                                        <span style="font-size: 12px; color: #047857; font-weight:600;">🏫 {{ $santri->kelas->nama_kelas }}</span>
                                    @else
                                        <span style="font-size: 12px; color: #9ca3af; font-style:italic;">Tanpa Kelas</span>
                                    @endif
                                </td>
                                @for($m = 1; $m <= 12; $m++)
                                    @php
                                        $monthPayments = $payments->get($santri->id);
                                        $payment = $monthPayments ? $monthPayments->firstWhere('bulan', $m) : null;
                                    @endphp
                                    <td>
                                        @if($payment)
                                            <span class="status-paid" title="Lunas: Rp {{ number_format($payment->jumlah, 0, ',', '.') }}&#10;Tgl Bayar: {{ date('d/m/Y', strtotime($payment->tanggal_bayar)) }}">
                                                Lunas
                                            </span>
                                        @else
                                            <button class="btn-pay" onclick="openPaymentModal({{ $santri->id }}, '{{ $santri->nama_santri }}', {{ $m }}, {{ $year }})">
                                                Bayar
                                            </button>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" style="text-align:center; color:#9ca3af;">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Pembayaran SPP -->
    <div class="modal" id="payment-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Input Pembayaran SPP</h3>
                <button class="modal-close" onclick="closePaymentModal()">&times;</button>
            </div>
            <form action="{{ route('tpq.keuangan.spp.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="tb_santri_id" name="tb_santri_id">
                    <input type="hidden" id="bulan" name="bulan">
                    <input type="hidden" id="tahun" name="tahun">

                    <div class="form-group">
                        <label>Nama Santri</label>
                        <input type="text" id="nama_santri" readonly>
                    </div>

                    <div class="form-group">
                        <label>Bulan / Tahun SPP</label>
                        <input type="text" id="bulan_tahun_label" readonly>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Nominal Pembayaran (Rp)</label>
                        <input type="number" id="jumlah" name="jumlah" value="20000" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_bayar">Tanggal Pembayaran</label>
                        <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-pay" onclick="closePaymentModal()">Batal</button>
                    <button type="submit" class="button-primary" style="padding: 10px 18px; border-radius: 8px;">Simpan & Kirim WA</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }

        // Modal Logic
        const modal = document.getElementById('payment-modal');
        const monthNames = [
            "", "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        function openPaymentModal(santriId, name, month, year) {
            document.getElementById('tb_santri_id').value = santriId;
            document.getElementById('nama_santri').value = name;
            document.getElementById('bulan').value = month;
            document.getElementById('tahun').value = year;
            
            document.getElementById('bulan_tahun_label').value = monthNames[month] + " " + year;
            modal.classList.add('open');
        }

        function closePaymentModal() {
            modal.classList.remove('open');
        }
    </script>
</body>
</html>
