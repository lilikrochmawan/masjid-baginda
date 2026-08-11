<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap SPP TPQ - Baginda</title>
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

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 800px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; text-decoration: none; font-weight: 700; font-size: 11px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }

        /* ── Print Header (Screen Hidden) ── */
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
            .sidebar, .topbar, .sidebar-overlay, .tabs-nav, .filters, .alert, .btn-action { display: none !important; }
            .main { margin-left: 0; padding: 0; background: white; }
            .section { box-shadow: none; padding: 0; }
            th, td { padding: 10px 8px; font-size: 12px; }
            .print-header { display: block; }
            th { background: #f1f5f9 !important; border-bottom: 2px solid #000 !important; color: #000 !important; }
            td, th { border-bottom: 1px solid #cbd5e1 !important; color: #000 !important; }
        }

        /* ── Pagination Buttons ── */
        .pagination-btn { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .pagination-btn:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .pagination-btn.active { background: #10b981; color: white; border-color: #10b981; pointer-events: none; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; background: #ffffff; border-color: #e6f4ed; color: #9ca3af; }
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
        <!-- Print Header -->
        <div class="print-header">
            <div class="print-logo-container">
                <img src="{{ asset('images/image.png') }}" class="print-logo" alt="Masjid Baginda">
                <div>
                    <div class="print-title">MASJID BAGINDA - REKAP SPP TPQ</div>
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
            <a href="{{ route('tpq.keuangan.rekap.index') }}" class="tab-btn active">Rekap SPP</a>
            <a href="{{ route('tpq.keuangan.kas.index') }}" class="tab-btn">Arus Kas (Cashflow)</a>
            <a href="{{ route('tpq.keuangan.laporan.index') }}" class="tab-btn">Laporan Kas</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px;">
                <h2 style="margin-bottom: 0;">Rekap Pembayaran SPP Bulanan</h2>
                <div style="display: flex; gap: 12px; align-items: center; margin: 0; flex-wrap: wrap;">
                    <input type="text" id="tableSearchInput" placeholder="Cari data..." style="padding: 10px 14px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; min-width: 200px; outline: none; transition: border-color 0.2s;">
                    
                    <form class="filters" action="{{ route('tpq.keuangan.rekap.index') }}" method="GET" style="margin: 0; display: flex; gap: 12px; align-items: center;">
                        <label style="display: flex; flex-direction: row; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #164a3f; margin-bottom: 0;">
                            Bulan
                            <select name="month" onchange="this.form.submit()" style="padding: 8px 10px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; outline: none; cursor: pointer;">
                                <option value="">Semua Bulan</option>
                                @for($m = 1; $m <= 12; $m++)
                                    @php
                                        $monthName = \Carbon\Carbon::create()->month($m)->format('F');
                                    @endphp
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $monthName }}</option>
                                @endfor
                            </select>
                        </label>
                        <label style="display: flex; flex-direction: row; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #164a3f; margin-bottom: 0;">
                            Tahun
                            <select name="year" onchange="this.form.submit()" style="padding: 8px 10px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; outline: none; cursor: pointer;">
                                @for($y = date('Y') - 3; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </label>
                        <label style="display: flex; flex-direction: row; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #164a3f; margin-bottom: 0;">
                            Filter Kelas
                            <select name="kelas_id" onchange="this.form.submit()" style="padding: 8px 10px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; outline: none; cursor: pointer; min-width: 140px;">
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </label>
                        <button type="button" class="print-btn" onclick="window.print()" style="padding: 8px 14px; border-radius: 10px; font-weight: 700; font-size: 13.5px; background: #0f766e; color: white;">🖨️ Cetak</button>
                    </form>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Bayar</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Kelas</th>
                            <th>Bulan / Tahun SPP</th>
                            <th>Jumlah</th>
                            <th>Diterima Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                            @php
                                $bulanName = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ][$pay->bulan];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($pay->tanggal_bayar)) }}</td>
                                <td>{{ $pay->santri->nis ?? '-' }}</td>
                                <td><strong>{{ $pay->santri->nama_santri }}</strong></td>
                                <td>
                                    @if($pay->santri->kelas)
                                        <span>{{ $pay->santri->kelas->nama_kelas }}</span>
                                    @else
                                        <span style="color:#9ca3af; font-style:italic;">Tanpa Kelas</span>
                                    @endif
                                </td>
                                <td>{{ $bulanName }} {{ $pay->tahun }}</td>
                                <td><strong>Rp {{ number_format($pay->jumlah, 0, ',', '.') }}</strong></td>
                                <td>{{ $pay->user->name ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('tpq.keuangan.spp.broadcast', $pay->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-action" title="Kirim Ulang Broadcast WA">
                                            📲 Kirim WA
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row">
                                <td colspan="9" style="text-align:center; color:#9ca3af;">Tidak ditemukan riwayat pembayaran SPP.</td>
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

        // Client-side search and pagination logic
        const tableSearchInput = document.getElementById('tableSearchInput');
        const tableBody = document.querySelector('table tbody');
        const allRows = Array.from(tableBody.querySelectorAll('tr:not(.no-data-row)'));
        
        let filteredRows = [...allRows];
        const rowsPerPage = 10;
        let currentPage = 1;

        function updateTable() {
            const query = tableSearchInput.value.toLowerCase().trim();
            
            // 1. Filter rows based on search
            filteredRows = allRows.filter(row => {
                const cells = Array.from(row.querySelectorAll('td'));
                const searchString = cells.map(td => td.textContent.toLowerCase()).join(' ');
                return searchString.includes(query);
            });

            // Handle "No data" message row
            let noDataRow = tableBody.querySelector('.no-match-row');
            if (filteredRows.length === 0) {
                if (!noDataRow) {
                    noDataRow = document.createElement('tr');
                    noDataRow.className = 'no-match-row';
                    noDataRow.innerHTML = '<td colspan="9" style="text-align:center; color:#9ca3af; padding: 20px 0;">Tidak ada rekap SPP yang cocok.</td>';
                    tableBody.appendChild(noDataRow);
                } else {
                    noDataRow.style.display = '';
                }
                const originalNoDataRow = tableBody.querySelector('.no-data-row');
                if (originalNoDataRow) originalNoDataRow.style.display = 'none';
            } else {
                if (noDataRow) {
                    noDataRow.style.display = 'none';
                }
            }

            // 2. Paginate filtered rows
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

            // Hide all data rows first
            allRows.forEach(row => row.style.display = 'none');

            // Show matching rows for current page
            for (let i = startIndex; i < endIndex; i++) {
                filteredRows[i].style.display = '';
                filteredRows[i].firstElementChild.textContent = i + 1;
            }

            // 3. Update pagination controls
            document.getElementById('start-row').textContent = totalRows > 0 ? startIndex + 1 : 0;
            document.getElementById('end-row').textContent = endIndex;
            document.getElementById('total-rows').textContent = totalRows;

            const buttonsContainer = document.getElementById('pagination-buttons');
            buttonsContainer.innerHTML = '';

            if (totalPages > 1) {
                // Prev button
                const prevBtn = document.createElement('button');
                prevBtn.className = 'pagination-btn';
                prevBtn.textContent = 'Sebelumnya';
                prevBtn.disabled = currentPage === 1;
                prevBtn.onclick = () => {
                    currentPage--;
                    updateTable();
                };
                buttonsContainer.appendChild(prevBtn);

                // Page numbers
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                for (let p = startPage; p <= endPage; p++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = 'pagination-btn' + (p === currentPage ? ' active' : '');
                    pageBtn.textContent = p;
                    pageBtn.onclick = () => {
                        currentPage = p;
                        updateTable();
                    };
                    buttonsContainer.appendChild(pageBtn);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.className = 'pagination-btn';
                nextBtn.textContent = 'Berikutnya';
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.onclick = () => {
                    currentPage++;
                    updateTable();
                };
                buttonsContainer.appendChild(nextBtn);
            }
        }

        // Attach event listener
        tableSearchInput.addEventListener('input', () => {
            currentPage = 1;
            updateTable();
        });

        // Initialize table
        updateTable();
    </script>
</body>
</html>
