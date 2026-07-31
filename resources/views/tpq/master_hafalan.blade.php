<!DOCTYPE html>
<html lang="en">
<head>
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
                <h2>Daftar Hafalan</h2>
                
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
                                <tr>
                                    <td colspan="5" style="text-align: center; color:#6b7280; padding:20px;">Belum ada master data hafalan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    </script>
</body>
</html>
