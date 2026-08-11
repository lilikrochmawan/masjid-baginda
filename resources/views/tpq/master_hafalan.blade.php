<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Hafalan TPQ - Baginda</title>
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

        .grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 24px; }
        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); margin-bottom: 20px; }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; outline: none; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #10b981; }
        
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #6b7280; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .btn-danger { color: #dc2626; border-color: #fecaca; }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-surah { background: #e0f2fe; color: #0369a1; }
        .badge-doa { background: #fef3c7; color: #d97706; }

        @media (max-width: 1024px) { .grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            th, td { padding: 10px 8px; font-size: 12px; }
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
            @if(auth()->user()->hasAccess('tpq.prestasi'))
            <a href="{{ route('tpq.prestasi.index') }}">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            @endif
            <a href="{{ route('tpq.master-hafalan.index') }}" class="active">
                <span class="nav-icon">⚙️</span> Master Hafalan
            </a>
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
        <span class="topbar-brand">Master Hafalan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Master Data Hafalan TPQ</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <!-- Left Side: Form Tambah/Ubah -->
            <div class="section">
                <h2 id="formTitle">Tambah Master Hafalan</h2>
                
                <form id="hafalanForm" action="{{ route('tpq.master-hafalan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="form-group">
                        <label for="kategori">Kategori Hafalan</label>
                        <select name="kategori" id="kategori" required>
                            <option value="surah_pendek">Surah Pendek</option>
                            <option value="doa_harian">Doa Sehari-hari</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Hafalan</label>
                        <input type="text" name="nama" id="nama" placeholder="Contoh: Surah An-Nas, Doa Keluar Rumah" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="4" placeholder="Detail ayat atau keterangan lainnya..."></textarea>
                    </div>

                    <button type="submit" class="button-primary" id="btnSubmit">Simpan Data</button>
                    <button type="button" class="button-secondary" id="btnReset" style="display: none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right Side: Daftar Master Data -->
            <div class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px;">
                    <h2 style="margin-bottom: 0;">Daftar Hafalan</h2>
                    <input type="text" id="tableSearchInput" placeholder="Cari hafalan..." style="padding: 10px 14px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; min-width: 200px; outline: none; transition: border-color 0.2s;">
                </div>
                
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th style="width: 140px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($item->kategori === 'surah_pendek')
                                            <span class="badge badge-surah">Surah Pendek</span>
                                        @else
                                            <span class="badge badge-doa">Doa Harian</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td style="text-align: center;">
                                        <button class="btn-action" onclick="editHafalan({{ json_encode($item) }})">Edit</button>
                                        <form action="{{ route('tpq.master-hafalan.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data master ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="no-data-row">
                                    <td colspan="5" style="text-align: center; color:#6b7280; padding:20px;">Belum ada master data hafalan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Controls -->
                <div id="pagination-controls" style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 12px; border-top: 1px solid #e6f4ed; flex-wrap: wrap; gap: 10px;">
                    <div id="pagination-info" style="font-size: 13px; color: #5c7b73;">
                        Menampilkan <span id="start-row">0</span> - <span id="end-row">0</span> dari <span id="total-rows">0</span> hafalan
                    </div>
                    <div style="display: flex; gap: 6px;" id="pagination-buttons"></div>
                </div>
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

        // Form handling
        const form = document.getElementById('hafalanForm');
        const formTitle = document.getElementById('formTitle');
        const formMethod = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnReset = document.getElementById('btnReset');

        const inputKategori = document.getElementById('kategori');
        const inputNama = document.getElementById('nama');
        const inputKeterangan = document.getElementById('keterangan');

        function editHafalan(item) {
            formTitle.textContent = 'Ubah Master Hafalan';
            form.action = `/tpq/master-hafalan/${item.id}`;
            formMethod.value = 'PUT';
            btnSubmit.textContent = 'Perbarui Data';
            btnReset.style.display = 'inline-block';

            inputKategori.value = item.kategori;
            inputNama.value = item.nama;
            inputKeterangan.value = item.keterangan || '';
            
            inputNama.focus();
        }

        function resetForm() {
            formTitle.textContent = 'Tambah Master Hafalan';
            form.action = "{{ route('tpq.master-hafalan.store') }}";
            formMethod.value = 'POST';
            btnSubmit.textContent = 'Simpan Data';
            btnReset.style.display = 'none';

            inputKategori.value = 'surah_pendek';
            inputNama.value = '';
            inputKeterangan.value = '';
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
                    noDataRow.innerHTML = '<td colspan="5" style="text-align:center; color:#9ca3af; padding: 20px 0;">Tidak ada data hafalan yang cocok.</td>';
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
