<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventarisasi Barang - Baginda</title>
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
        .page-title { margin-bottom: 20px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        .grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 24px; }
        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(16,185,129,0.06); margin-bottom: 20px; border: 1px solid rgba(16,185,129,0.08); }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #0f172a; background: #fafafa; }
        .form-group textarea { min-height: 80px; resize: vertical; }

        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); background: #059669; }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #64748b; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* ── Tabs Navigation ── */
        .tabs-header { display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 16px; gap: 8px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .tab-btn { padding: 10px 20px; border: none; background: none; font-weight: 600; font-size: 14px; color: #64748b; cursor: pointer; position: relative; bottom: -2px; border-bottom: 2px solid transparent; transition: all 0.2s; white-space: nowrap; }
        .tab-btn:hover { color: #10b981; }
        .tab-btn.active { color: #10b981; border-bottom: 2px solid #10b981; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* ── Table Layout ── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #1e293b; }
        th { background: #f0fdf4; font-weight: 700; color: #0f766e; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #0f766e; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .btn-danger { color: #dc2626; border-color: #fecaca; }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }

        @media (max-width: 1024px) { .grid { grid-template-columns: 1fr; } }
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

    @php
        $activeTab = request('tab', 'inventaris');
    @endphp

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>📋</span> Data Operasional
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('operasional.dashboard') }}">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @if(auth()->user()->hasAccess('operasional.struktur'))
            <a href="{{ route('operasional.struktur.index') }}">
                <span class="nav-icon">👥</span> Struktur Takmir
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.inventaris'))
            <a href="{{ route('operasional.inventaris.index') }}" class="active">
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
        <span class="topbar-brand">Inventarisasi</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Inventarisasi Barang</h1>
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

        <div class="grid">
            <!-- Left: Forms (Conditional based on active tab) -->
            <div class="section" id="form-container">
                
                <!-- Form 1: Unit Inventaris (Default) -->
                <div id="form-pane-inventaris" class="form-pane">
                    <h2 id="form-title-inventaris">Registrasi Unit Aset Fisik</h2>
                    <form id="inventaris-form" action="{{ route('operasional.inventaris.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="method-inventaris" name="_method" value="POST">

                        <div class="form-group">
                            <label for="tb_barang_id">Pilih Master Barang</label>
                            <select id="tb_barang_id" name="tb_barang_id" required>
                                <option value="">Pilih barang...</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->jenis->nama_jenis }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_perolehan">Tanggal Perolehan / Masuk</label>
                            <input type="date" id="tanggal_perolehan" name="tanggal_perolehan" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label for="asal_usul">Asal Usul Barang</label>
                            <input type="text" id="asal_usul" name="asal_usul" required placeholder="Contoh: Pembelian Kas Masjid, Wakaf Bpk. X">
                        </div>

                        <div class="form-group">
                            <label for="kondisi">Kondisi Aset</label>
                            <select id="kondisi" name="kondisi" required>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Lokasi Penempatan</label>
                            <input type="text" id="lokasi" name="lokasi" required placeholder="Contoh: Ruang Utama, Gudang Utama, Halaman">
                        </div>

                        <div class="form-group">
                            <label for="harga_perolehan">Harga Perolehan (nominal rupiah, opsional)</label>
                            <input type="number" id="harga_perolehan" name="harga_perolehan" min="0" placeholder="Contoh: 1500000">
                        </div>

                        <button type="submit" class="button-primary" id="btn-submit-inventaris">Simpan Unit Aset</button>
                        <button type="button" class="button-secondary" id="btn-cancel-inventaris" style="display:none;" onclick="resetFormInventaris()">Batal</button>
                    </form>
                </div>

                <!-- Form 2: Master Barang -->
                <div id="form-pane-barang" class="form-pane" style="display:none;">
                    <h2 id="form-title-barang">Tambah Master Barang baru</h2>
                    <form id="barang-form" action="{{ route('operasional.barang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="method-barang" name="_method" value="POST">

                        <div class="form-group">
                            <label for="tb_jenis_barang_id">Jenis Barang / Kategori</label>
                            <select id="tb_jenis_barang_id" name="tb_jenis_barang_id" required>
                                <option value="">Pilih jenis...</option>
                                @foreach($jenisBarangs as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama_barang">Nama Master Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" required placeholder="Contoh: AC Sharp 1.5 PK, Sajadah Gulung">
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan Hitung</label>
                            <input type="text" id="satuan" name="satuan" required placeholder="Contoh: Unit, Roll, Lembar, Pcs" value="Unit">
                        </div>

                        <div class="form-group">
                            <label for="keterangan_barang">Keterangan / Spesifikasi (opsional)</label>
                            <textarea id="keterangan_barang" name="keterangan" placeholder="Masukkan keterangan tambahan"></textarea>
                        </div>

                        <button type="submit" class="button-primary" id="btn-submit-barang">Simpan Master Barang</button>
                        <button type="button" class="button-secondary" id="btn-cancel-barang" style="display:none;" onclick="resetFormBarang()">Batal</button>
                    </form>
                </div>

                <!-- Form 3: Jenis Barang (Kategori) -->
                <div id="form-pane-jenis" class="form-pane" style="display:none;">
                    <h2 id="form-title-jenis">Tambah Kategori / Jenis Barang</h2>
                    <form id="jenis-form" action="{{ route('operasional.jenis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="method-jenis" name="_method" value="POST">

                        <div class="form-group">
                            <label for="nama_jenis">Nama Jenis Kategori</label>
                            <input type="text" id="nama_jenis" name="nama_jenis" required placeholder="Contoh: Elektronik, Peralatan Ibadah, Mebel">
                        </div>

                        <div class="form-group">
                            <label for="keterangan_jenis">Keterangan (opsional)</label>
                            <textarea id="keterangan_jenis" name="keterangan" placeholder="Masukkan keterangan tambahan"></textarea>
                        </div>

                        <button type="submit" class="button-primary" id="btn-submit-jenis">Simpan Kategori</button>
                        <button type="button" class="button-secondary" id="btn-cancel-jenis" style="display:none;" onclick="resetFormJenis()">Batal</button>
                    </form>
                </div>

            </div>

            <!-- Right: Tables with Tab Navigation -->
            <div class="section">
                <div class="tabs-header">
                    <button class="tab-btn" id="btn-tab-inventaris" onclick="switchTab('inventaris')">Unit Inventaris (Fisik)</button>
                    <button class="tab-btn" id="btn-tab-barang" onclick="switchTab('barang')">Master Barang</button>
                    <button class="tab-btn" id="btn-tab-jenis" onclick="switchTab('jenis')">Kategori / Jenis</button>
                </div>

                <!-- Tab 1: Unit Inventaris (Fisik) Table -->
                <div id="tab-inventaris" class="tab-content">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Aset</th>
                                    <th>Nama Barang</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi</th>
                                    <th>Tgl Perolehan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventaris as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong style="color:#059669;">{{ $item->kode_inventaris }}</strong></td>
                                        <td>
                                            <strong>{{ $item->barang->nama_barang }}</strong><br>
                                            <span style="font-size:11px; color:#64748b;">Kategori: {{ $item->barang->jenis->nama_jenis }}</span>
                                        </td>
                                        <td>
                                            @if($item->kondisi === 'baik')
                                                <span class="badge badge-success">Baik</span>
                                            @elseif($item->kondisi === 'rusak_ringan')
                                                <span class="badge badge-warning">Rusak Ringan</span>
                                            @else
                                                <span class="badge badge-danger">Rusak Berat</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_perolehan)) }}</td>
                                        <td>
                                            <button class="btn-action" onclick='editInventaris(@json($item))'>Ubah</button>
                                            <form action="{{ route('operasional.inventaris.destroy', $item->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit aset fisik ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; color:#94a3b8;">Belum ada registrasi fisik barang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 2: Master Barang Table -->
                <div id="tab-barang" class="tab-content">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                    <th>Jml Fisik</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span style="font-size:12px; font-weight:600; color:#0f766e;">{{ $item->jenis->nama_jenis }}</span></td>
                                        <td><strong>{{ $item->nama_barang }}</strong></td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $item->inventaris->count() }} unit</span></td>
                                        <td>
                                            <button class="btn-action" onclick='editBarang(@json($item))'>Ubah</button>
                                            <form action="{{ route('operasional.barang.destroy', $item->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus master barang ini? Unit fisik terdaftar juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; color:#94a3b8;">Belum ada data master barang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 3: Jenis Barang Table -->
                <div id="tab-jenis" class="tab-content">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah Master</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisBarangs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->nama_jenis }}</strong></td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $item->barangs->count() }} Item</span></td>
                                        <td>
                                            <button class="btn-action" onclick='editJenis(@json($item))'>Ubah</button>
                                            <form action="{{ route('operasional.jenis.destroy', $item->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Master barang di dalamnya akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:#94a3b8;">Belum ada kategori terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

        // Tab and Form switching logic
        function switchTab(tabName) {
            // Update Tab Button styles
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById('btn-tab-' + tabName);
            if (activeBtn) activeBtn.classList.add('active');

            // Update Tab Table contents
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            const activeContent = document.getElementById('tab-' + tabName);
            if (activeContent) activeContent.classList.add('active');

            // Update Left Column Form pane
            document.querySelectorAll('.form-pane').forEach(pane => pane.style.display = 'none');
            const activePane = document.getElementById('form-pane-' + tabName);
            if (activePane) activePane.style.display = 'block';
        }

        // Initialize based on PHP activeTab variable
        const currentActiveTab = "{{ $activeTab }}";
        switchTab(currentActiveTab);

        /* ── CRUD JS: Inventaris ── */
        const formInventaris = document.getElementById('inventaris-form');
        const formTitleInventaris = document.getElementById('form-title-inventaris');
        const methodInventaris = document.getElementById('method-inventaris');
        const submitInventaris = document.getElementById('btn-submit-inventaris');
        const cancelInventaris = document.getElementById('btn-cancel-inventaris');

        const barSelect = document.getElementById('tb_barang_id');
        const tglInput = document.getElementById('tanggal_perolehan');
        const asalInput = document.getElementById('asal_usul');
        const kondisiSelect = document.getElementById('kondisi');
        const lokInput = document.getElementById('lokasi');
        const hargaInput = document.getElementById('harga_perolehan');

        function editInventaris(item) {
            switchTab('inventaris');
            document.getElementById('form-container').scrollIntoView({ behavior: 'smooth' });

            formTitleInventaris.textContent = "Ubah Data Unit Aset";
            formInventaris.action = "{{ route('operasional.inventaris.update', ':id') }}".replace(':id', item.id);
            methodInventaris.value = "PUT";
            submitInventaris.textContent = "Simpan Perubahan";
            cancelInventaris.style.display = "inline-block";

            barSelect.value = item.tb_barang_id;
            tglInput.value = item.tanggal_perolehan;
            asalInput.value = item.asal_usul;
            kondisiSelect.value = item.kondisi;
            lokInput.value = item.lokasi;
            hargaInput.value = item.harga_perolehan || "";
        }

        function resetFormInventaris() {
            formTitleInventaris.textContent = "Registrasi Unit Aset Fisik";
            formInventaris.action = "{{ route('operasional.inventaris.store') }}";
            methodInventaris.value = "POST";
            submitInventaris.textContent = "Simpan Unit Aset";
            cancelInventaris.style.display = "none";
            formInventaris.reset();
            tglInput.value = "{{ date('Y-m-d') }}";
        }

        /* ── CRUD JS: Master Barang ── */
        const formBarang = document.getElementById('barang-form');
        const formTitleBarang = document.getElementById('form-title-barang');
        const methodBarang = document.getElementById('method-barang');
        const submitBarang = document.getElementById('btn-submit-barang');
        const cancelBarang = document.getElementById('btn-cancel-barang');

        const jenSelect = document.getElementById('tb_jenis_barang_id');
        const namaBarangInput = document.getElementById('nama_barang');
        const satInput = document.getElementById('satuan');
        const ketBarangInput = document.getElementById('keterangan_barang');

        function editBarang(item) {
            switchTab('barang');
            document.getElementById('form-container').scrollIntoView({ behavior: 'smooth' });

            formTitleBarang.textContent = "Ubah Master Barang";
            formBarang.action = "{{ route('operasional.barang.update', ':id') }}".replace(':id', item.id);
            methodBarang.value = "PUT";
            submitBarang.textContent = "Simpan Perubahan";
            cancelBarang.style.display = "inline-block";

            jenSelect.value = item.tb_jenis_barang_id;
            namaBarangInput.value = item.nama_barang;
            satInput.value = item.satuan;
            ketBarangInput.value = item.keterangan || "";
        }

        function resetFormBarang() {
            formTitleBarang.textContent = "Tambah Master Barang baru";
            formBarang.action = "{{ route('operasional.barang.store') }}";
            methodBarang.value = "POST";
            submitBarang.textContent = "Simpan Master Barang";
            cancelBarang.style.display = "none";
            formBarang.reset();
            satInput.value = "Unit";
        }

        /* ── CRUD JS: Jenis Barang ── */
        const formJenis = document.getElementById('jenis-form');
        const formTitleJenis = document.getElementById('form-title-jenis');
        const methodJenis = document.getElementById('method-jenis');
        const submitJenis = document.getElementById('btn-submit-jenis');
        const cancelJenis = document.getElementById('btn-cancel-jenis');

        const namaJenisInput = document.getElementById('nama_jenis');
        const ketJenisInput = document.getElementById('keterangan_jenis');

        function editJenis(item) {
            switchTab('jenis');
            document.getElementById('form-container').scrollIntoView({ behavior: 'smooth' });

            formTitleJenis.textContent = "Ubah Kategori Barang";
            formJenis.action = "{{ route('operasional.jenis.update', ':id') }}".replace(':id', item.id);
            methodJenis.value = "PUT";
            submitJenis.textContent = "Simpan Perubahan";
            cancelJenis.style.display = "inline-block";

            namaJenisInput.value = item.nama_jenis;
            ketJenisInput.value = item.keterangan || "";
        }

        function resetFormJenis() {
            formTitleJenis.textContent = "Tambah Kategori / Jenis Barang";
            formJenis.action = "{{ route('operasional.jenis.store') }}";
            methodJenis.value = "POST";
            submitJenis.textContent = "Simpan Kategori";
            cancelJenis.style.display = "none";
            formJenis.reset();
        }
    </script>
</body>
</html>
