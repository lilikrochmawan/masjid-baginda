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
            @if(auth()->user()->hasAccess('koin.qr.generate'))
<a href="{{ route('koin.qr.generate') }}">
                <span class="nav-icon">🖼️</span> Generate QR
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
            
            <div style="margin-bottom: 16px; display: flex; justify-content: flex-end;">
                <input type="text" id="searchKaleng" onkeyup="filterSearchKaleng()" placeholder="Cari nama kaleng, pemilik, atau alamat..." style="width: 100%; max-width: 350px; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #1e293b; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th onclick="sortKaleng('kode_kaleng')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Kode Kaleng 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-kaleng-kode_kaleng-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-kaleng-kode_kaleng-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortKaleng('nama_kaleng')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Nama Kaleng 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-kaleng-nama_kaleng-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-kaleng-nama_kaleng-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortKaleng('pemilik')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Pemilik 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-kaleng-pemilik-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-kaleng-pemilik-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortKaleng('alamat')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Alamat Pemilik 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-kaleng-alamat-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-kaleng-alamat-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortKaleng('status')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Status 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-kaleng-status-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-kaleng-status-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="kalengTableBody">
                    </tbody>
                </table>
            </div>
            <div id="kalengPagination" style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                <div id="paginationInfo" style="font-size:12.5px; color:#475569;"></div>
                <div id="paginationControls" style="display:flex; gap:6px;"></div>
            </div>
        </div>

        <div class="section">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px; flex-wrap:wrap; gap:10px;">
                <h2 style="margin-bottom:0;">2. Laporan Pemasukan Kaleng Global</h2>
                <button onclick="openPrintModal()" style="padding: 8px 16px; background:#10b981; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:6px; box-shadow: 0 4px 12px rgba(16,185,129,0.15); transition:background 0.2s;">
                    <span>🖨️</span> Cetak Laporan Global
                </button>
            </div>
            <div class="summary-grid">
                <div class="summary-grid">
                    <div class="summary-card">
                        <span>Total Penerimaan</span>
                        <strong>Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</strong>
                    </div>
                    <div class="summary-card">
                        <span>Jumlah catatan</span>
                        <strong>{{ $penerimaan->count() }}</strong>
                    </div>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th onclick="sortPenerimaan('tanggal_penerimaan')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Tanggal 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-penerimaan-tanggal_penerimaan-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-penerimaan-tanggal_penerimaan-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortPenerimaan('jumlah')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Jumlah 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-penerimaan-jumlah-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-penerimaan-jumlah-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortPenerimaan('keterangan')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                Keterangan 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-penerimaan-keterangan-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-penerimaan-keterangan-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                            <th onclick="sortPenerimaan('user_name')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                                User Input 
                                <svg class="sort-icon" width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-left: 4px; display: inline-block;">
                                    <path id="sort-penerimaan-user_name-up" d="M5 1L9 5H1L5 1Z" fill="#cbd5e1"/>
                                    <path id="sort-penerimaan-user_name-down" d="M5 11L1 7H9L5 11Z" fill="#cbd5e1"/>
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="penerimaanTableBody">
                    </tbody>
                </table>
            </div>
            <div id="penerimaanPagination" style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                <div id="penerimaanPaginationInfo" style="font-size:12.5px; color:#475569;"></div>
                <div id="penerimaanPaginationControls" style="display:flex; gap:6px;"></div>
            </div>
        </div>
    </main>

    <!-- Modal Filter Popup -->
    <div id="printModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.4); z-index:1000; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
        <div style="background:white; border-radius:16px; padding:24px; width:90%; max-width:400px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1); border:1px solid #e2e8f0; position:relative; animation: modalFade 0.2s ease-out;">
            <h3 style="margin-top:0; margin-bottom:16px; color:#0f4d36; font-size:18px; font-weight:700; display:flex; align-items:center; gap:8px;">
                <span>🖨️</span> Cetak Laporan Global
            </h3>
            
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:12.5px; font-weight:600; color:#334155; margin-bottom:6px;">Tipe Laporan</label>
                <select id="filterType" onchange="toggleFilterInputs()" style="width:100%; padding:10px; border-radius:8px; border:1px solid #cbd5e1; font-size:13.5px; color:#1e293b; background:white;">
                    <option value="bulanan">Laporan Bulanan</option>
                    <option value="tahunan">Laporan Tahunan</option>
                </select>
            </div>
            
            <div id="monthGroup" style="margin-bottom:16px;">
                <label style="display:block; font-size:12.5px; font-weight:600; color:#334155; margin-bottom:6px;">Bulan</label>
                <select id="filterMonth" style="width:100%; padding:10px; border-radius:8px; border:1px solid #cbd5e1; font-size:13.5px; color:#1e293b; background:white;">
                    @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $name)
                        <option value="{{ $num }}" {{ now()->month == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12.5px; font-weight:600; color:#334155; margin-bottom:6px;">Tahun</label>
                <input type="number" id="filterYear" value="{{ now()->year }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #cbd5e1; font-size:13.5px; color:#1e293b;" min="2020" max="2050">
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button onclick="closePrintModal()" style="padding:10px 16px; background:#f1f5f9; color:#475569; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:13px;">Batal</button>
                <button onclick="submitPrint()" style="padding:10px 16px; background:#10b981; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:13px; display:flex; align-items:center; gap:6px;">Cetak</button>
            </div>
        </div>
    </div>
   
    <style>
        @keyframes modalFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pagination-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .pagination-btn:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .pagination-btn.active {
            background: #10b981;
            color: #ffffff;
            border-color: #10b981;
        }
    </style>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }

        // --- Data Laporan Kaleng ---
        const allKalengs = @json($allKalengs);
        let filteredKalengs = [...allKalengs];
        let currentSortCol = '';
        let currentSortDir = 'asc';
        let currentPage = 1;
        const rowsPerPage = 10;

        function filterSearchKaleng() {
            const query = document.getElementById('searchKaleng').value.toLowerCase().trim();
            
            if (query === '') {
                filteredKalengs = [...allKalengs];
            } else {
                filteredKalengs = allKalengs.filter(k => {
                    return (k.nama_kaleng || '').toLowerCase().includes(query) ||
                           (k.pemilik || '').toLowerCase().includes(query) ||
                           (k.alamat || '').toLowerCase().includes(query);
                });
            }
            
            currentPage = 1;
            renderTable();
        }

        function sortKaleng(col) {
            if (currentSortCol === col) {
                currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
            } else {
                currentSortCol = col;
                currentSortDir = 'asc';
            }
            
            // Reset all sort icons in Table 1
            const cols = ['kode_kaleng', 'nama_kaleng', 'pemilik', 'alamat', 'status'];
            cols.forEach(c => {
                document.getElementById('sort-kaleng-' + c + '-up').setAttribute('fill', '#cbd5e1');
                document.getElementById('sort-kaleng-' + c + '-down').setAttribute('fill', '#cbd5e1');
            });

            // Set active sort icon in Table 1
            const activeArrowId = 'sort-kaleng-' + col + '-' + (currentSortDir === 'asc' ? 'up' : 'down');
            document.getElementById(activeArrowId).setAttribute('fill', '#059669');

            const sortFn = (a, b) => {
                if (a.status_code !== b.status_code) {
                    return a.status_code - b.status_code; // 0 comes before 1
                }

                let valA = (a[col] || '').toString().toLowerCase();
                let valB = (b[col] || '').toString().toLowerCase();

                if (valA < valB) return currentSortDir === 'asc' ? -1 : 1;
                if (valA > valB) return currentSortDir === 'asc' ? 1 : -1;
                return 0;
            };

            allKalengs.sort(sortFn);
            filteredKalengs.sort(sortFn);

            currentPage = 1;
            renderTable();
        }

        function renderTable() {
            const tbody = document.getElementById('kalengTableBody');
            tbody.innerHTML = '';

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const pageData = filteredKalengs.slice(start, end);

            if (pageData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#64748b; padding:20px;">Tidak ada data kaleng.</td></tr>';
                document.getElementById('paginationInfo').textContent = '';
                document.getElementById('paginationControls').innerHTML = '';
                return;
            }

            pageData.forEach((k, idx) => {
                const tr = document.createElement('tr');
                
                const tdNum = document.createElement('td');
                tdNum.textContent = start + idx + 1;
                tr.appendChild(tdNum);

                const tdKode = document.createElement('td');
                tdKode.textContent = k.kode_kaleng;
                tr.appendChild(tdKode);

                const tdNama = document.createElement('td');
                tdNama.textContent = k.nama_kaleng;
                tr.appendChild(tdNama);

                const tdPemilik = document.createElement('td');
                tdPemilik.textContent = k.pemilik;
                tr.appendChild(tdPemilik);

                const tdAlamat = document.createElement('td');
                tdAlamat.textContent = k.alamat;
                tr.appendChild(tdAlamat);

                const tdStatus = document.createElement('td');
                const badge = document.createElement('span');
                badge.className = 'badge';
                if (k.status_code === 0) {
                    badge.textContent = 'Belum Scan';
                    badge.style.background = '#fef3c7';
                    badge.style.color = '#92400e';
                } else {
                    badge.textContent = 'Sudah Scan';
                }
                tdStatus.appendChild(badge);
                tr.appendChild(tdStatus);

                tbody.appendChild(tr);
            });

            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredKalengs.length / rowsPerPage);
            const info = document.getElementById('paginationInfo');
            const controls = document.getElementById('paginationControls');

            info.textContent = `Menampilkan ${Math.min(filteredKalengs.length, (currentPage - 1) * rowsPerPage + 1)} - ${Math.min(filteredKalengs.length, currentPage * rowsPerPage)} dari ${filteredKalengs.length} kaleng`;

            controls.innerHTML = '';
            if (totalPages <= 1) return;

            // Prev button
            const btnPrev = document.createElement('button');
            btnPrev.className = 'pagination-btn';
            btnPrev.textContent = 'Sebelumnya';
            btnPrev.disabled = currentPage === 1;
            btnPrev.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
            controls.appendChild(btnPrev);

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const btnPage = document.createElement('button');
                btnPage.className = 'pagination-btn' + (currentPage === i ? ' active' : '');
                btnPage.textContent = i;
                btnPage.onclick = () => { currentPage = i; renderTable(); };
                controls.appendChild(btnPage);
            }

            // Next button
            const btnNext = document.createElement('button');
            btnNext.className = 'pagination-btn';
            btnNext.textContent = 'Berikutnya';
            btnNext.disabled = currentPage === totalPages;
            btnNext.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
            controls.appendChild(btnNext);
        }

        // --- Data Laporan Penerimaan Global ---
        const allPenerimaans = @json($penerimaanList);
        let filteredPenerimaans = [...allPenerimaans];
        let currentPenerimaanSortCol = '';
        let currentPenerimaanSortDir = 'asc';
        let currentPenerimaanPage = 1;
        const penerimaanRowsPerPage = 10;

        function sortPenerimaan(col) {
            if (currentPenerimaanSortCol === col) {
                currentPenerimaanSortDir = currentPenerimaanSortDir === 'asc' ? 'desc' : 'asc';
            } else {
                currentPenerimaanSortCol = col;
                currentPenerimaanSortDir = 'asc';
            }
            
            // Reset all sort icons in Table 2
            const cols = ['tanggal_penerimaan', 'jumlah', 'keterangan', 'user_name'];
            cols.forEach(c => {
                document.getElementById('sort-penerimaan-' + c + '-up').setAttribute('fill', '#cbd5e1');
                document.getElementById('sort-penerimaan-' + c + '-down').setAttribute('fill', '#cbd5e1');
            });

            // Set active sort icon in Table 2
            const activeArrowId = 'sort-penerimaan-' + col + '-' + (currentPenerimaanSortDir === 'asc' ? 'up' : 'down');
            document.getElementById(activeArrowId).setAttribute('fill', '#059669');

            const sortFn = (a, b) => {
                let valA = a[col];
                let valB = b[col];

                if (col === 'jumlah') {
                    return currentPenerimaanSortDir === 'asc' ? valA - valB : valB - valA;
                }

                valA = (valA || '').toString().toLowerCase();
                valB = (valB || '').toString().toLowerCase();
                if (valA < valB) return currentPenerimaanSortDir === 'asc' ? -1 : 1;
                if (valA > valB) return currentPenerimaanSortDir === 'asc' ? 1 : -1;
                return 0;
            };

            allPenerimaans.sort(sortFn);
            filteredPenerimaans.sort(sortFn);

            currentPenerimaanPage = 1;
            renderPenerimaanTable();
        }

        function renderPenerimaanTable() {
            const tbody = document.getElementById('penerimaanTableBody');
            tbody.innerHTML = '';

            const start = (currentPenerimaanPage - 1) * penerimaanRowsPerPage;
            const end = start + penerimaanRowsPerPage;
            const pageData = filteredPenerimaans.slice(start, end);

            if (pageData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#64748b; padding:20px;">Tidak ada data penerimaan.</td></tr>';
                document.getElementById('penerimaanPaginationInfo').textContent = '';
                document.getElementById('penerimaanPaginationControls').innerHTML = '';
                return;
            }

            pageData.forEach((item, idx) => {
                const tr = document.createElement('tr');
                
                const tdNum = document.createElement('td');
                tdNum.textContent = start + idx + 1;
                tr.appendChild(tdNum);

                const tdTanggal = document.createElement('td');
                tdTanggal.textContent = item.tanggal_formatted;
                tr.appendChild(tdTanggal);

                const tdJumlah = document.createElement('td');
                tdJumlah.textContent = item.jumlah_formatted;
                tr.appendChild(tdJumlah);

                const tdKeterangan = document.createElement('td');
                tdKeterangan.textContent = item.keterangan;
                tr.appendChild(tdKeterangan);

                const tdUser = document.createElement('td');
                tdUser.textContent = item.user_name;
                tr.appendChild(tdUser);

                tbody.appendChild(tr);
            });

            renderPenerimaanPagination();
        }

        function renderPenerimaanPagination() {
            const totalPages = Math.ceil(filteredPenerimaans.length / penerimaanRowsPerPage);
            const info = document.getElementById('penerimaanPaginationInfo');
            const controls = document.getElementById('penerimaanPaginationControls');

            info.textContent = `Menampilkan ${Math.min(filteredPenerimaans.length, (currentPenerimaanPage - 1) * penerimaanRowsPerPage + 1)} - ${Math.min(filteredPenerimaans.length, currentPenerimaanPage * penerimaanRowsPerPage)} dari ${filteredPenerimaans.length} catatan`;

            controls.innerHTML = '';
            if (totalPages <= 1) return;

            // Prev button
            const btnPrev = document.createElement('button');
            btnPrev.className = 'pagination-btn';
            btnPrev.textContent = 'Sebelumnya';
            btnPrev.disabled = currentPenerimaanPage === 1;
            btnPrev.onclick = () => { if (currentPenerimaanPage > 1) { currentPenerimaanPage--; renderPenerimaanTable(); } };
            controls.appendChild(btnPrev);

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const btnPage = document.createElement('button');
                btnPage.className = 'pagination-btn' + (currentPenerimaanPage === i ? ' active' : '');
                btnPage.textContent = i;
                btnPage.onclick = () => { currentPenerimaanPage = i; renderPenerimaanTable(); };
                controls.appendChild(btnPage);
            }

            // Next button
            const btnNext = document.createElement('button');
            btnNext.className = 'pagination-btn';
            btnNext.textContent = 'Berikutnya';
            btnNext.disabled = currentPenerimaanPage === totalPages;
            btnNext.onclick = () => { if (currentPenerimaanPage < totalPages) { currentPenerimaanPage++; renderPenerimaanTable(); } };
            controls.appendChild(btnNext);
        }

        // --- Print Modal Actions ---
        function openPrintModal() {
            document.getElementById('printModal').style.display = 'flex';
        }

        function closePrintModal() {
            document.getElementById('printModal').style.display = 'none';
        }

        function toggleFilterInputs() {
            const type = document.getElementById('filterType').value;
            const monthGroup = document.getElementById('monthGroup');
            if (type === 'bulanan') {
                monthGroup.style.display = 'block';
            } else {
                monthGroup.style.display = 'none';
            }
        }

        function submitPrint() {
            const type = document.getElementById('filterType').value;
            const month = document.getElementById('filterMonth').value;
            const year = document.getElementById('filterYear').value;
            
            let url = `{{ route('koin.laporan.print') }}?type=${type}&tahun=${year}`;
            if (type === 'bulanan') {
                url += `&bulan=${month}`;
            }
            
            window.open(url, '_blank');
            closePrintModal();
        }

        // Init tables
        // "Belum Scan" is automatically sorted at the beginning initially
        allKalengs.sort((a, b) => a.status_code - b.status_code);
        renderTable();
        renderPenerimaanTable();
    </script>
</body>
</html>
