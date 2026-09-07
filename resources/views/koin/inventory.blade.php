<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori Kaleng - Koin Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f4fbf7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; height: 100vh; background: linear-gradient(180deg, #059669 0%, #047857 100%); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 200; transition: transform 0.3s ease; overflow-y: auto; }
        .sidebar-brand { padding: 22px 20px 18px; font-size: 18px; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .sidebar-brand span { font-size: 22px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .sidebar-nav a, .sidebar-nav button { display: flex; align-items: center; gap: 10px; width: 100%; padding: 11px 20px; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 13.5px; font-weight: 500; border: none; background: none; cursor: pointer; transition: background 0.2s, color 0.2s; text-align: left; }
        .sidebar-nav a:hover, .sidebar-nav button:hover { background: rgba(255,255,255,0.12); color: white; }
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
        .grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 18px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 16px rgba(15,60,40,0.07); }
        .card h2 { color: #0f4d36; margin-bottom: 14px; font-size: 18px; }
        .alert { padding: 12px 14px; border-radius: 10px; margin-bottom: 14px; font-size: 13px; }
        .alert-success { background: #d1fae5; color: #0f5132; border: 1px solid #a7f3d0; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; margin-bottom: 6px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group textarea { width: 100%; padding: 11px 12px; border-radius: 8px; border: 1px solid #cfe9dd; background: #f8fffb; color: #114e37; font-size: 14px; }
        .form-group textarea { min-height: 80px; resize: vertical; }
        .form-actions { display: flex; justify-content: flex-end; }
        .btn-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 10px; padding: 11px 18px; cursor: pointer; font-weight: 700; font-size: 13px; }
        .btn-primary:hover { opacity: .92; }
        .table-wrapper { overflow-x: auto; margin-top: 14px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 11px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; color: #164a3f; font-size: 13px; }
        table th { background: #effff6; font-weight: 700; }
        table tbody tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 999px; background: #e0f8e8; color: #0f5132; font-size: 12px; font-weight: 600; }
        .btn-ubah { padding: 6px 12px; border-radius: 8px; border: none; background: #0f766e; color: white; cursor: pointer; font-size: 12px; font-weight: 600; transition: opacity 0.2s; white-space: nowrap; }
        .btn-ubah:hover { opacity: 0.85; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 500; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: white; border-radius: 14px; padding: 28px; width: 100%; max-width: 460px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); margin: 16px; }
        .modal h3 { color: #0f4d36; font-size: 18px; margin-bottom: 20px; }
        .modal .form-group { margin-bottom: 14px; }
        .modal .form-group label { display: block; margin-bottom: 6px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .modal .form-group input, .modal .form-group textarea { width: 100%; padding: 11px 12px; border-radius: 8px; border: 1px solid #cfe9dd; background: #f8fffb; color: #114e37; font-size: 14px; }
        .modal .form-group textarea { min-height: 80px; resize: vertical; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { padding: 10px 18px; border-radius: 8px; border: 1px solid #d1d5db; background: white; color: #374151; cursor: pointer; font-size: 13px; }
        .btn-save { padding: 10px 20px; border-radius: 8px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; cursor: pointer; font-weight: 700; font-size: 13px; }

        @media (max-width: 1024px) { .grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 20px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .grid { grid-template-columns: 1fr; gap: 12px; }
            .card { padding: 16px 14px; }
            .form-group input, .form-group textarea { font-size: 16px; padding: 12px; }
            .form-actions { justify-content: center; }
            .btn-primary { width: 100%; }
            .table-wrapper { -webkit-overflow-scrolling: touch; }
            table th, table td { padding: 10px 8px; font-size: 12px; }
        }

        /* ── Pagination Styling ── */
        .pagination { display: flex; list-style: none; padding: 0; margin: 15px 0 0; justify-content: center; gap: 6px; }
        .page-item .page-link { display: inline-block; padding: 8px 14px; border-radius: 8px; border: 1px solid #cfe9dd; color: #059669; text-decoration: none; font-size: 13px; font-weight: 600; background: white; transition: all 0.2s; cursor: pointer; }
        .page-item:hover .page-link { background: #e6f4ed; color: #047857; border-color: #a7f3d0; }
        .page-item.active .page-link { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-color: #059669; font-weight: 700; cursor: default; }
        .page-item.disabled .page-link { color: #94a3b8; background: #f8fafc; border-color: #e2e8f0; cursor: not-allowed; }
        
        .pagination-info { text-align: center; margin-top: 15px; font-size: 12px; color: #64748b; }
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
<a href="{{ route('koin.inventory') }}" class="active">
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
<a href="{{ route('koin.laporan') }}">
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
        <span class="topbar-brand">Inventori Kaleng</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Inventori Kaleng</h1></div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <div class="card">
                <h2>Tambah Kaleng</h2>
                <form action="{{ route('koin.inventory.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kaleng">Nama Kaleng</label>
                        <input type="text" id="nama_kaleng" name="nama_kaleng" value="{{ old('nama_kaleng') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="form-actions">
                        <button class="btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                     <h2 style="margin: 0;">Daftar Kaleng</h2>
                     <form action="{{ route('koin.inventory') }}" method="GET" style="display: flex; gap: 6px; width: 100%; max-width: 300px;">
                         <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kode, nama, pemilik..." style="flex: 1; padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; background: #fff;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#cbd5e1'">
                         <button type="submit" class="btn-primary" style="padding: 8px 14px; font-size: 13px; margin: 0; border-radius: 8px; cursor: pointer;">Cari</button>
                     </form>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Pemilik</th>
                                <th>No. WA</th>
                                <th>Alamat</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kalengs as $kaleng)
                                <tr>
                                    <td>{{ $loop->iteration + ($kalengs->firstItem() - 1) }}</td>
                                    <td><span class="badge">{{ $kaleng->kode_kaleng }}</span></td>
                                    <td>{{ $kaleng->nama_kaleng }}</td>
                                    <td>{{ $kaleng->latestPemilik?->nama ?? '-' }}</td>
                                    <td>{{ $kaleng->latestPemilik?->no_wa ?? '-' }}</td>
                                    <td>{{ $kaleng->latestPemilik?->alamat ?? '-' }}</td>
                                    <td>{{ $kaleng->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($kaleng->latestPemilik)
                                            <button type="button" class="btn-ubah"
                                                data-id="{{ $kaleng->latestPemilik->id }}"
                                                data-nama="{{ $kaleng->latestPemilik->nama }}"
                                                data-wa="{{ $kaleng->latestPemilik->no_wa }}"
                                                data-alamat="{{ $kaleng->latestPemilik->alamat }}"
                                                data-kode="{{ $kaleng->kode_kaleng }}"
                                                onclick="openModal(this)">
                                                ✏️ Ubah
                                            </button>
                                        @else
                                            <span style="color:#9ca3af;font-size:12px;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; color: #94a3b8; padding: 20px 0;">Tidak ada data kaleng yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($kalengs->total() > 0)
                     <div class="pagination-info">
                         Menampilkan {{ $kalengs->firstItem() }} - {{ $kalengs->lastItem() }} dari {{ $kalengs->total() }} kaleng
                     </div>
                     {{ $kalengs->links('pagination::bootstrap-4') }}
                @endif
            </div>
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

    <!-- Modal Ubah Pemilik -->
    <div class="modal-overlay" id="modal-ubah">
        <div class="modal">
            <h3>✏️ Ubah Data Pemilik</h3>
            <form id="form-ubah" method="POST">
                @csrf
                @method('PUT')
                <div style="background:#f0fdf4;padding:10px 14px;border-radius:8px;margin-bottom:16px;font-size:12px;color:#166534;">
                    Kaleng: <strong id="modal-kode"></strong>
                </div>
                <div class="form-group">
                    <label for="edit_nama">Nama Pemilik</label>
                    <input type="text" id="edit_nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="edit_no_wa">Nomor WhatsApp</label>
                    <input type="text" id="edit_no_wa" name="no_wa" required>
                </div>
                <div class="form-group">
                    <label for="edit_alamat">Alamat</label>
                    <textarea id="edit_alamat" name="alamat" required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal     = document.getElementById('modal-ubah');
        const formUbah  = document.getElementById('form-ubah');
        const modalKode = document.getElementById('modal-kode');
        const editNama  = document.getElementById('edit_nama');
        const editNoWa  = document.getElementById('edit_no_wa');
        const editAlamat = document.getElementById('edit_alamat');

        function openModal(btn) {
            formUbah.action = '{{ url('koin-baginda/pemilik') }}/' + btn.dataset.id;
            modalKode.textContent = btn.dataset.kode;
            editNama.value   = btn.dataset.nama;
            editNoWa.value   = btn.dataset.wa;
            editAlamat.value = btn.dataset.alamat;
            modal.classList.add('open');
        }

        function closeModal() {
            modal.classList.remove('open');
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    </script>
</body>
</html>
