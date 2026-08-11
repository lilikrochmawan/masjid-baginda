<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
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

        /* ── Pagination Buttons ── */
        .pagination-btn { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .pagination-btn:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .pagination-btn.active { background: #10b981; color: white; border-color: #10b981; pointer-events: none; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; background: #ffffff; border-color: #e6f4ed; color: #9ca3af; }

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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px;">
                <h2 style="margin-bottom: 0;">Peta Pembayaran SPP Tahun {{ $year }}</h2>
                
                <div style="display: flex; gap: 12px; align-items: center; margin: 0; flex-wrap: wrap;">
                    <input type="text" id="tableSearchInput" placeholder="Cari nama / NIS..." style="padding: 10px 14px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; min-width: 200px; outline: none; transition: border-color 0.2s;">
                    
                    <form class="filters" action="{{ route('tpq.keuangan.spp.index') }}" method="GET" style="margin: 0; display: flex; gap: 12px; align-items: center;">
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
                    </form>
                </div>
            </div>

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
                            <tr class="no-data-row">
                                <td colspan="16" style="text-align:center; color:#9ca3af;">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div id="pagination-controls" style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 12px; border-top: 1px solid #e6f4ed; flex-wrap: wrap; gap: 10px;">
                <div id="pagination-info" style="font-size: 13px; color: #5c7b73;">
                    Menampilkan <span id="start-row">0</span> - <span id="end-row">0</span> dari <span id="total-rows">0</span> santri
                </div>
                <div style="display: flex; gap: 6px;" id="pagination-buttons"></div>
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
                // Search in NIS, Nama Santri, and Kelas (first 4 columns)
                const searchString = cells.slice(0, 4).map(td => td.textContent.toLowerCase()).join(' ');
                return searchString.includes(query);
            });

            // Handle "No data" message row
            let noDataRow = tableBody.querySelector('.no-match-row');
            if (filteredRows.length === 0) {
                if (!noDataRow) {
                    noDataRow = document.createElement('tr');
                    noDataRow.className = 'no-match-row';
                    noDataRow.innerHTML = '<td colspan="16" style="text-align:center; color:#9ca3af; padding: 20px 0;">Tidak ada data santri yang cocok.</td>';
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
