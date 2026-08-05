<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Persuratan - Baginda</title>
    <style>
        .tox-tinymce {
            border: none !important;
            box-shadow: none !important;
        }
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
        
        /* Tab Styles */
        .tabs-header { display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 2px solid #e2e8f0; padding-bottom: 2px; }
        .tab-btn { padding: 10px 20px; font-size: 14px; font-weight: 600; color: #64748b; background: none; border: none; cursor: pointer; border-radius: 8px 8px 0 0; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .tab-btn:hover { color: #10b981; background: rgba(16,185,129,0.05); }
        .tab-btn.active { color: #047857; border-bottom-color: #047857; background: white; }

        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .page-title { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        /* Forms & Grid */
        .grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 24px; }
        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(16,185,129,0.06); margin-bottom: 20px; border: 1px solid rgba(16,185,129,0.08); }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #0f172a; background: #fafafa; }
        .form-group textarea { min-height: 80px; resize: vertical; }

        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; }
        .button-primary:hover { transform: translateY(-1px); background: #059669; }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #64748b; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .filter-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 12px; flex-wrap: wrap; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px; }
        .filter-bar select { padding: 8px 12px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fafafa; color: #0f766e; cursor: pointer; outline: none; }

        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 650px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #1e293b; }
        th { background: #f0fdf4; font-weight: 700; color: #0f766e; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #0f766e; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .btn-danger { color: #dc2626; border-color: #fecaca; }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }
        .btn-success { color: #10b981; border-color: #bbf7d0; }
        .btn-success:hover { background: #f0fdf4; border-color: #86efac; }
        .btn-info { color: #2563eb; border-color: #bfdbfe; }
        .btn-info:hover { background: #eff6ff; border-color: #93c5fd; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-masuk { background: #e6f4ed; color: #059669; }
        .badge-keluar { background: #f3e8ff; color: #7e22ce; }
        .badge-proposal { background: #fef3c7; color: #d97706; }
        .badge-pending { background: #cbd5e1; color: #475569; }
        .badge-disetujui { background: #dcfce7; color: #15803d; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }

        /* WPS / Word Office Look-alike styles */
        .wps-editor-container { display: grid; grid-template-columns: 350px 1fr; gap: 24px; margin-top: 15px; }
        .wps-paper-wrapper { background-color: #e2e8f0; min-height: 100vh; padding: 30px 10px; overflow-y: auto; display: block; }
        .editor-header-bar { 
            position: sticky; 
            top: 0; 
            padding: 15px 20px 10px 20px; 
            background: #f8fafc; 
            z-index: 100; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            border-bottom: 1px solid #cbd5e1; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); 
            margin: -30px -10px 30px -10px; 
            width: calc(100% + 20px); 
            box-sizing: border-box;
        }
        .editor-header-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        #editor-toolbar-container { display: flex; justify-content: center; width: 100%; min-height: 45px; }
        .zoom-control { display: flex; align-items: center; gap: 8px; background: white; padding: 6px 12px; border-radius: 6px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .zoom-control select { border: none; outline: none; font-weight: 700; color: #0f4d36; cursor: pointer; background: transparent; font-size: 13px; }
        .zoom-control label { font-size: 12px; color: #64748b; font-weight: 700; }
        .wps-paper { margin: 0 auto; width: 100%; max-width: 210mm; min-height: 297mm; background: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 25mm 20mm; position: relative; border-radius: 4px; box-sizing: border-box; transition: zoom 0.2s ease, max-width 0.3s ease; text-align: left; }
        
        .wps-kop { display: flex; align-items: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px; }
        .wps-kop-logo { flex: 0 0 80px; text-align: left; }
        .wps-kop-logo img { width: 75px; height: auto; }
        .wps-kop-text { flex: 1; text-align: center; padding-right: 80px; }
        .wps-kop-text h2 { font-size: 20px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px; color: #000 !important; margin-top: 0; }
        .wps-kop-text p { font-size: 12px; color: #334155; line-height: 1.4; margin: 0; }
        
        /* Simulating Physical Page Breaks for TinyMCE */
        .wps-paper img.mce-pagebreak, .wps-paper hr.mce-pagebreak {
            display: block !important;
            width: calc(100% + 40mm) !important;
            height: 35px !important;
            margin: 30px -20mm !important;
            background-color: #e2e8f0 !important;
            border: none !important;
            border-top: 1px solid #cbd5e1 !important;
            border-bottom: 1px solid #cbd5e1 !important;
            box-shadow: inset 0 3px 6px rgba(0,0,0,0.04), inset 0 -3px 6px rgba(0,0,0,0.04) !important;
            page-break-before: always !important;
            cursor: default !important;
        }

        /* Modal Styles */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; padding: 20px; }
        .modal.open { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 24px; width: 100%; max-width: 700px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); position: relative; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h3 { color: #0f4d36; font-size: 18px; font-weight: 700; }
        .modal-close { background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8; }
        
        .sig-pad-container { border: 2px dashed #cbd5e1; border-radius: 12px; background: #fafafa; position: relative; margin-bottom: 16px; }
        .sig-canvas { width: 100%; height: 220px; display: block; border-radius: 12px; cursor: crosshair; touch-action: none; }
        .sig-buttons { display: flex; justify-content: space-between; margin-top: 10px; }

        .tte-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 20px; }
        .tte-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; text-align: center; background: #f8fafc; }
        .tte-card h4 { font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #334155; }
        .tte-status { margin-bottom: 10px; }
        .tte-img { max-height: 50px; margin: 8px 0; border: 1px solid #f1f5f9; background: white; }

        @media (max-width: 1024px) {
            .grid { grid-template-columns: 1fr; }
            .wps-editor-container { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .tabs-header { overflow-x: auto; white-space: nowrap; }
        }
    </style>
</head>
<body>

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
            <a href="{{ route('operasional.inventaris.index') }}">
                <span class="nav-icon">📦</span> Inventarisasi Barang
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.surat'))
            <a href="{{ route('operasional.surat.index') }}" class="active">
                <span class="nav-icon">✉️</span> Persuratan
            </a>
            <a href="{{ route('operasional.broadcast.index') }}">
                <span class="nav-icon">📢</span> Pengumuman
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
        <span class="topbar-brand">Persuratan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <!-- Tabs Header -->
        <div class="tabs-header">
            <button class="tab-btn active" onclick="switchTab('arsip-tab')">Arsip Surat & Proposal</button>
            <button class="tab-btn" onclick="switchTab('buat-surat-tab')">Pembuatan Surat Resmi</button>
        </div>

        <!-- System Alerts -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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

        <!-- TAB 1: ARSIP SURAT & PROPOSAL -->
        <div id="arsip-tab" class="tab-content active">
            <div class="page-title">
                <h1>Pencatatan Surat & Proposal</h1>
            </div>

            <div class="grid">
                <!-- Left: Form -->
                <div class="section" id="form-container">
                    <h2 id="form-title">Pencatatan Surat / Proposal</h2>
                    <form id="surat-form" action="{{ route('operasional.surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="method-field" name="_method" value="POST">

                        <div class="form-group">
                            <label for="tipe">Tipe Dokumen</label>
                            <select id="tipe" name="tipe" required onchange="handleTipeChange()">
                                <option value="masuk">Surat Masuk</option>
                                <option value="keluar">Surat Keluar</option>
                                <option value="proposal">Proposal Kegiatan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nomor_surat_input">Nomor Surat / Proposal</label>
                            <input type="text" id="nomor_surat_input" name="nomor_surat" required placeholder="Contoh: 120/TKM-MB/VI/2026">
                        </div>

                        <div class="form-group">
                            <label for="perihal_input">Perihal / Subject</label>
                            <input type="text" id="perihal_input" name="perihal" required placeholder="Contoh: Permohonan Bantuan Dana Ramadhan">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_surat_input">Tanggal Surat</label>
                            <input type="date" id="tanggal_surat_input" name="tanggal_surat" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group" id="group-tgl-diterima">
                            <label for="tanggal_diterima">Tanggal Diterima</label>
                            <input type="date" id="tanggal_diterima" name="tanggal_diterima" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group" id="group-pengirim">
                            <label for="pengirim">Pengirim / Pengaju</label>
                            <input type="text" id="pengirim" name="pengirim" placeholder="Contoh: Panitia PHBI, Remaja Masjid">
                        </div>

                        <div class="form-group" id="group-penerima" style="display:none;">
                            <label for="penerima">Penerima Surat</label>
                            <input type="text" id="penerima" name="penerima" placeholder="Contoh: Lurah, Bpk. Donatur">
                        </div>

                        <div class="form-group" id="group-status-proposal" style="display:none;">
                            <label for="status_proposal">Status Verifikasi Proposal</label>
                            <select id="status_proposal" name="status_proposal">
                                <option value="pending">Pending</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="file_dokumen">Upload Berkas / Lampiran <span style="font-weight:normal; color:#64748b;">(PDF, Gambar, Max 5MB, opsional)</span></label>
                            <input type="file" id="file_dokumen" name="file_dokumen">
                            <div id="file-info" style="margin-top: 8px; font-size: 13px; color: #047857; font-weight: 600; display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan / Catatan Tambahan <span style="font-weight:normal; color:#64748b;">(opsional)</span></label>
                            <textarea id="keterangan" name="keterangan" placeholder="Masukkan catatan tambahan jika ada"></textarea>
                        </div>

                        <button type="submit" class="button-primary" id="btn-submit">Simpan Dokumen</button>
                        <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                    </form>
                </div>

                <!-- Right: Table List -->
                <div class="section">
                    <div class="filter-bar">
                        <h2>Arsip Dokumen</h2>
                        <select id="filter-tipe" onchange="filterTable()">
                            <option value="semua">TIPE: Semua</option>
                            <option value="masuk">TIPE: Surat Masuk</option>
                            <option value="keluar">TIPE: Surat Keluar</option>
                            <option value="proposal">TIPE: Proposal</option>
                        </select>
                    </div>

                    <div class="table-wrapper">
                        <table id="arsip-table">
                            <thead>
                                <tr>
                                    <th>No. Surat / Perihal</th>
                                    <th>Tipe</th>
                                    <th>Pihak Terkait</th>
                                    <th>Tgl Surat</th>
                                    <th>Berkas</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surats as $s)
                                    <tr data-tipe="{{ $s->tipe }}">
                                        <td>
                                            <div style="font-weight: 700; color:#0f4d36;">{{ $s->nomor_surat }}</div>
                                            <div style="font-size: 12px; color: #475569; margin-top:2px;">{{ $s->perihal }}</div>
                                        </td>
                                        <td>
                                            @if($s->tipe === 'masuk')
                                                <span class="badge badge-masuk">Masuk</span>
                                            @elseif($s->tipe === 'keluar')
                                                <span class="badge badge-keluar">Keluar</span>
                                            @else
                                                <span class="badge badge-proposal">Proposal</span>
                                                <div style="margin-top:4px;">
                                                    @if($s->status_proposal === 'pending')
                                                        <span class="badge badge-pending">Pending</span>
                                                    @elseif($s->status_proposal === 'disetujui')
                                                        <span class="badge badge-disetujui">Disetujui</span>
                                                    @else
                                                        <span class="badge badge-ditolak">Ditolak</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-weight:600;">
                                                @if($s->tipe === 'keluar')
                                                    Tujuan: {{ $s->penerima ?? '-' }}
                                                @else
                                                    Pengirim: {{ $s->pengirim ?? '-' }}
                                                @endif
                                            </div>
                                            @if($s->tipe === 'masuk' && $s->tanggal_diterima)
                                                <div style="font-size:11px; color:#64748b; margin-top:2px;">Diterima: {{ $s->tanggal_diterima->format('d/m/Y') }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $s->tanggal_surat->format('d/m/Y') }}</td>
                                        <td>
                                            @if($s->file_path)
                                                <a href="{{ asset('storage/' . $s->file_path) }}" target="_blank" class="btn-action">Unduh</a>
                                            @else
                                                <span style="color:#94a3b8; font-style:italic; font-size:12px;">Tanpa Berkas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn-action" onclick="editSurat({{ json_encode($s) }})">Edit</button>
                                            <form action="{{ route('operasional.surat.destroy', $s->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data surat/proposal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color:#64748b; padding: 30px 0;">Belum ada arsip surat terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: PEMBUATAN SURAT RESMI -->
        <div id="buat-surat-tab" class="tab-content">
            <div id="list-surat-buat-view">
                <div class="page-title">
                    <h1>Pembuatan Surat Resmi & TTE</h1>
                    <button class="button-primary" onclick="showEditor()">Buat Surat Baru</button>
                </div>

                <div class="section">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>No. Surat / Perihal</th>
                                    <th>Jenis Template</th>
                                    <th>Tanggal</th>
                                    <th>Tujuan</th>
                                    <th>Tanda Tangan (TTE)</th>
                                    <th style="width: 260px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratBuats as $sb)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color:#0f4d36;">{{ $sb->nomor_surat }}</div>
                                            <div style="font-size: 12px; color: #475569; margin-top:2px;">{{ $sb->perihal }}</div>
                                            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Dibuat oleh: {{ $sb->creator?->name ?? 'Admin' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge badge-keluar">{{ strtoupper($sb->template_key) }}</span>
                                            @if($sb->is_draft)
                                                <span class="badge" style="background: #cbd5e1; color: #334155; margin-left: 4px; font-weight:700;">DRAF</span>
                                            @endif
                                        </td>
                                        <td>{{ $sb->tanggal_surat->format('d M Y') }}</td>
                                        <td>{{ $sb->tujuan_surat ?? '-' }}</td>
                                        <td>
                                            <div style="display:flex; flex-direction:column; gap:4px; font-size:11px;">
                                                <div>Sekretaris: {!! $sb->status_sekretaris === 'signed' ? '<span style="color:#059669; font-weight:700;">Sudah TTD</span>' : '<span style="color:#64748b;">Belum</span>' !!}</div>
                                                <div>Ketua: {!! $sb->status_ketua === 'signed' ? '<span style="color:#059669; font-weight:700;">Sudah TTD</span>' : '<span style="color:#64748b;">Belum</span>' !!}</div>
                                                <div>Penasehat: {!! $sb->status_penasehat === 'signed' ? '<span style="color:#059669; font-weight:700;">Sudah TTD</span>' : '<span style="color:#64748b;">Belum</span>' !!}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn-action btn-success" onclick="openSignatureModal({{ json_encode($sb) }})">Sign TTE</button>
                                            <button class="btn-action btn-info" onclick="editSuratBuat({{ json_encode($sb) }})">Edit</button>
                                            <a href="{{ route('operasional.surat-buat.print', $sb->id) }}" target="_blank" class="btn-action">Cetak</a>
                                            <form action="{{ route('operasional.surat-buat.destroy', $sb->id) }}" method="POST" style="display:inline; margin-left:4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color:#64748b; padding: 30px 0;">Belum ada surat resmi yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- WPS Look-alike Letter Creator Workspace (Hidden by default) -->
            <div id="editor-surat-buat-view" style="display: none;">
                <div class="page-title">
                    <h1 id="editor-view-title">Buat Surat Resmi Baru</h1>
                    <button class="button-secondary" onclick="hideEditor()" style="margin:0;">Kembali ke Daftar</button>
                </div>

                <form id="surat-buat-form" action="{{ route('operasional.surat-buat.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="sb-method-field" name="_method" value="POST">
                    <input type="hidden" id="sb-isi-surat" name="isi_surat">
                    <input type="hidden" id="sb_is_draft" name="is_draft" value="0">

                    <div class="wps-editor-container">
                        <!-- Left Panel: Configurations -->
                        <div class="section" style="margin-bottom:0;">
                            <h2>Konfigurasi Surat</h2>
                            
                            <div class="form-group">
                                <label for="sb_template_key">Template Surat</label>
                                <select id="sb_template_key" name="template_key" required onchange="applyLetterTemplate()">
                                    <option value="kustom">Surat Kustom / Kosong</option>
                                    <option value="undangan">Surat Undangan Takmir</option>
                                    <option value="tugas">Surat Tugas</option>
                                    <option value="keputusan">Surat Keputusan (SK)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sb_header_title">Kop Surat: Judul Utama</label>
                                <input type="text" id="sb_header_title" name="header_title" required value="TAKMIR MASJID BAGINDA" oninput="syncLiveKop()">
                            </div>

                            <div class="form-group">
                                <label for="sb_header_subtitle">Kop Surat: Sub-title / Alamat</label>
                                <textarea id="sb_header_subtitle" name="header_subtitle" required oninput="syncLiveKop()">Perum Taman Harmoni Jeruk Sawit, Mojorejo, Gondangrejo, Karanganyar&#10;Telp: 0812-3456-7890 | Email: takmir@masjidbaginda.org</textarea>
                            </div>

                            <div class="form-group">
                                <label for="sb_nomor_surat">Nomor Surat</label>
                                <input type="text" id="sb_nomor_surat" name="nomor_surat" required value="{{ $autoNomorSurat }}">
                            </div>

                            <div class="form-group">
                                <label for="sb_perihal">Perihal</label>
                                <input type="text" id="sb_perihal" name="perihal" required placeholder="Contoh: Undangan Rapat Kerja Takmir">
                            </div>

                            <div class="form-group">
                                <label for="sb_tanggal_surat">Tanggal Surat</label>
                                <input type="date" id="sb_tanggal_surat" name="tanggal_surat" required value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group">
                                <label for="sb_tujuan_surat">Tujuan Penerima</label>
                                <input type="text" id="sb_tujuan_surat" name="tujuan_surat" placeholder="Contoh: Yth. Bpk. Ahmad Khoirudin">
                            </div>

                            <hr style="margin: 20px 0; border: none; border-top: 1px solid #cbd5e1;">
                            <h2>Nama Penandatangan (TTE)</h2>

                            <div class="form-group">
                                <label for="sb_nama_sekretaris">Nama Sekretaris</label>
                                <input type="text" id="sb_nama_sekretaris" name="nama_sekretaris" value="{{ \App\Models\Takmir::where('jabatan', 'Sekretaris')->first()->nama ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="sb_nama_ketua">Nama Ketua Takmir</label>
                                <input type="text" id="sb_nama_ketua" name="nama_ketua" value="{{ \App\Models\Takmir::where('jabatan', 'Ketua')->first()->nama ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="sb_nama_penasehat">Nama Penasehat</label>
                                <input type="text" id="sb_nama_penasehat" name="nama_penasehat" value="{{ \App\Models\Takmir::where('jabatan', 'Penasehat')->first()->nama ?? '' }}">
                            </div>

                            <div style="display: flex; gap: 8px; margin-top: 15px;">
                                <button type="submit" class="button-secondary" style="flex: 1; padding: 10px 0; font-weight:700;" onclick="document.getElementById('sb_is_draft').value = '1'">Simpan Draf</button>
                                <button type="submit" class="button-primary" style="flex: 1; padding: 10px 0; font-weight:700;" onclick="document.getElementById('sb_is_draft').value = '0'">Simpan & Terbitkan</button>
                            </div>
                        </div>

                        <!-- Right Panel: WPS Paper Sheet and TinyMCE Inline Editor -->
                        <div class="wps-paper-wrapper">
                            <div class="editor-header-bar">
                                <div class="editor-header-controls">
                                    <div class="zoom-control">
                                        <label for="paper-size">Kertas:</label>
                                        <select id="paper-size" onchange="changePaperSize()">
                                            <option value="A4" selected>A4</option>
                                            <option value="F4">F4 / Folio</option>
                                            <option value="Letter">Letter</option>
                                        </select>
                                    </div>
                                    <div class="zoom-control">
                                        <label for="paper-zoom">Zoom:</label>
                                        <select id="paper-zoom" onchange="changePaperZoom()">
                                            <option value="0.5">50%</option>
                                            <option value="0.75">75%</option>
                                            <option value="0.9">90%</option>
                                            <option value="1" selected>100%</option>
                                            <option value="1.25">125%</option>
                                            <option value="1.5">150%</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="editor-toolbar-container"></div>
                            </div>

                            <div class="wps-paper" id="wps-paper-sheet">
                                <!-- Kop Surat (Sync live with configuration inputs) -->
                                @php
                                    $setting = \App\Models\Setting::first();
                                    $logoUrl = $setting && $setting->logo ? asset('storage/' . $setting->logo) : null;
                                @endphp
                                <div class="wps-kop">
                                    <div class="wps-kop-logo">
                                        @if($logoUrl)
                                            <img src="{{ $logoUrl }}" alt="Logo">
                                        @endif
                                    </div>
                                    <div class="wps-kop-text">
                                        <h2 id="live-kop-title">TAKMIR MASJID BAGINDA</h2>
                                        <p id="live-kop-subtitle" style="white-space: pre-line;">Perum Taman Harmoni Jeruk Sawit, Mojorejo, Gondangrejo, Karanganyar<br>Telp: 0812-3456-7890 | Email: takmir@masjidbaginda.org</p>
                                    </div>
                                </div>

                                <!-- TinyMCE Inline Editor Container -->
                                <div id="quill-editor" contenteditable="true" style="min-height: 600px; outline: none; border: none; width: 100%; padding-top: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Modal Tanda Tangan Elektronik (TTE) -->
    <div id="tte-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tanda Tangan Elektronik (TTE) Surat Resmi</h3>
                <button class="modal-close" onclick="closeSignatureModal()">&times;</button>
            </div>
            
            <div style="font-size:14px; margin-bottom: 20px; color:#475569;">
                Silakan lakukan proses penandatanganan elektronik untuk pengurus takmir berikut. Tanda tangan yang berhasil disimpan akan langsung dimasukkan ke dalam format cetak surat.
            </div>

            <div class="tte-grid">
                <!-- TTD Sekretaris -->
                <div class="tte-card">
                    <h4>Sekretaris</h4>
                    <div class="tte-status" id="status-sekretaris-box">
                        <span class="badge badge-pending">Belum TTD</span>
                    </div>
                    <div id="img-sekretaris-container"></div>
                    <button class="btn-action" style="width:100%; margin-top:10px;" id="btn-sign-sekretaris" onclick="startSigning('sekretaris')">Tanda Tangani</button>
                </div>

                <!-- TTD Ketua Takmir -->
                <div class="tte-card">
                    <h4>Ketua Takmir</h4>
                    <div class="tte-status" id="status-ketua-box">
                        <span class="badge badge-pending">Belum TTD</span>
                    </div>
                    <div id="img-ketua-container"></div>
                    <button class="btn-action" style="width:100%; margin-top:10px;" id="btn-sign-ketua" onclick="startSigning('ketua')">Tanda Tangani</button>
                </div>

                <!-- TTD Penasehat -->
                <div class="tte-card">
                    <h4>Penasehat</h4>
                    <div class="tte-status" id="status-penasehat-box">
                        <span class="badge badge-pending">Belum TTD</span>
                    </div>
                    <div id="img-penasehat-container"></div>
                    <button class="btn-action" style="width:100%; margin-top:10px;" id="btn-sign-penasehat" onclick="startSigning('penasehat')">Tanda Tangani</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tanda Tangan Elektronik (TTE) -->
    <div id="sig-pad-modal" class="modal" style="z-index: 1100;">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <h3 id="sig-pad-title">Bubuhkan TTE (QR Code)</h3>
                <button class="modal-close" onclick="closeSigPad()">&times;</button>
            </div>
            
            <div class="form-group">
                <label for="nama_penandatangan_input">Nama Penandatangan</label>
                <input type="text" id="nama_penandatangan_input" required>
            </div>

            <div style="font-size: 13px; color: #475569; margin-bottom: 20px; line-height: 1.4;">
                Sistem akan secara otomatis menautkan TTE ini dengan QR Code verifikasi unik. Klik tombol di bawah untuk menyetujui.
            </div>

            <div class="sig-buttons" style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" class="button-secondary" onclick="closeSigPad()" style="margin:0;">Batal</button>
                <button type="button" class="button-primary" onclick="saveSignature()">Bubuhkan TTE</button>
            </div>
        </div>
    </div>

    <!-- Include TinyMCE Editor Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Global error listener for debugging
        window.addEventListener('error', function(e) {
            let errorDiv = document.createElement('div');
            errorDiv.style.position = 'fixed';
            errorDiv.style.top = '10px';
            errorDiv.style.left = '50%';
            errorDiv.style.transform = 'translateX(-50%)';
            errorDiv.style.background = '#fecaca';
            errorDiv.style.color = '#991b1b';
            errorDiv.style.padding = '15px 25px';
            errorDiv.style.borderRadius = '8px';
            errorDiv.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            errorDiv.style.zIndex = '99999';
            errorDiv.style.fontWeight = 'bold';
            errorDiv.innerHTML = 'JS Error: ' + e.message + ' (line ' + e.lineno + ')';
            document.body.appendChild(errorDiv);
        });

        // Tab switching logic
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            const activeBtn = Array.from(document.querySelectorAll('.tab-btn')).find(btn => btn.getAttribute('onclick').includes(tabId));
            if (activeBtn) activeBtn.classList.add('active');

            const activeContent = document.getElementById(tabId);
            if (activeContent) activeContent.classList.add('active');

            // Save tab state in URL
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId === 'arsip-tab' ? 'arsip' : 'buat-surat');
            window.history.pushState({}, '', url);
        }

        // Initialize active tab from URL query params
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam === 'buat-surat') {
                switchTab('buat-surat-tab');
            } else {
                switchTab('arsip-tab');
            }
        });

        // Toggle Sidebar on Mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('open');
            });
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
            });
        }

        // --- ARSIP SURAT & PROPOSAL LOGIC ---
        function handleTipeChange() {
            const tipe = document.getElementById('tipe').value;
            const groupDiterima = document.getElementById('group-tgl-diterima');
            const groupPengirim = document.getElementById('group-pengirim');
            const groupPenerima = document.getElementById('group-penerima');
            const groupStatusProposal = document.getElementById('group-status-proposal');

            if (tipe === 'masuk') {
                groupDiterima.style.display = 'block';
                groupPengirim.style.display = 'block';
                groupPenerima.style.display = 'none';
                groupStatusProposal.style.display = 'none';
            } else if (tipe === 'keluar') {
                groupDiterima.style.display = 'none';
                groupPengirim.style.display = 'none';
                groupPenerima.style.display = 'block';
                groupStatusProposal.style.display = 'none';
            } else if (tipe === 'proposal') {
                groupDiterima.style.display = 'block';
                groupPengirim.style.display = 'block';
                groupPenerima.style.display = 'none';
                groupStatusProposal.style.display = 'block';
            }
        }

        function filterTable() {
            const filter = document.getElementById('filter-tipe').value;
            const rows = document.querySelectorAll('#arsip-table tbody tr');

            rows.forEach(row => {
                const rowTipe = row.getAttribute('data-tipe');
                if (filter === 'semua' || rowTipe === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function editSurat(s) {
            document.getElementById('form-title').innerText = 'Edit Surat / Proposal';
            const form = document.getElementById('surat-form');
            form.action = "{{ route('operasional.surat.update', ':id') }}".replace(':id', s.id);
            document.getElementById('method-field').value = 'PUT';

            document.getElementById('tipe').value = s.tipe;
            document.getElementById('nomor_surat_input').value = s.nomor_surat;
            document.getElementById('perihal_input').value = s.perihal;
            
            // Format dates
            const dateStr = s.tanggal_surat ? s.tanggal_surat.split('T')[0] : '';
            document.getElementById('tanggal_surat_input').value = dateStr;

            if (s.tanggal_diterima) {
                document.getElementById('tanggal_diterima').value = s.tanggal_diterima.split('T')[0];
            }

            document.getElementById('pengirim').value = s.pengirim || '';
            document.getElementById('penerima').value = s.penerima || '';
            document.getElementById('status_proposal').value = s.status_proposal || 'pending';
            document.getElementById('keterangan').value = s.keterangan || '';

            if (s.file_path) {
                const fileInfo = document.getElementById('file-info');
                fileInfo.innerHTML = `Berkas saat ini: <a href="/storage/${s.file_path}" target="_blank" style="color: #047857; text-decoration: underline;">Unduh Berkas</a>`;
                fileInfo.style.display = 'block';
            } else {
                document.getElementById('file-info').style.display = 'none';
            }

            handleTipeChange();
            document.getElementById('btn-cancel').style.display = 'inline-block';
            document.getElementById('btn-submit').innerText = 'Perbarui Dokumen';
            
            // Scroll to form
            document.getElementById('form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('form-title').innerText = 'Pencatatan Surat / Proposal';
            const form = document.getElementById('surat-form');
            form.action = "{{ route('operasional.surat.store') }}";
            document.getElementById('method-field').value = 'POST';
            form.reset();
            document.getElementById('file-info').style.display = 'none';
            document.getElementById('btn-cancel').style.display = 'none';
            document.getElementById('btn-submit').innerText = 'Simpan Dokumen';
            handleTipeChange();
        }

        // --- PEMBUATAN SURAT RESMI WORKSPACE LOGIC ---
        window.pendingEditorContent = '';

        function initTinyMCE() {
            if (typeof tinymce === 'undefined') {
                console.warn('TinyMCE is not loaded yet. Retrying in 200ms...');
                setTimeout(initTinyMCE, 200);
                return;
            }
            if (!tinymce.get('quill-editor')) {
                tinymce.init({
                    selector: '#quill-editor',
                    inline: true,
                    fixed_toolbar_container: '#editor-toolbar-container',
                    base_url: 'https://cdn.jsdelivr.net/npm/tinymce@6.8.3',
                    suffix: '.min',
                    menubar: false,
                    branding: false,
                    placeholder: 'Mulai menulis isi surat di sini...',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount pagebreak code',
                    toolbar_mode: 'wrap',
                    toolbar: [
                        'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | align lineheight',
                        'numlist bullist indent outdent | link image media table | emoticons charmap | pagebreak removeformat | code'
                    ],
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                    setup: function (editor) {
                        editor.on('init', function () {
                            editor.setContent(window.pendingEditorContent || '');
                            editor.focus();
                            setTimeout(() => {
                                const wrapper = document.querySelector('.wps-paper-wrapper');
                                if(wrapper) wrapper.scrollTop = 0;
                            }, 50);
                        });
                    }
                });
            } else {
                tinymce.get('quill-editor').setContent(window.pendingEditorContent || '');
                tinymce.get('quill-editor').focus();
                setTimeout(() => {
                    const wrapper = document.querySelector('.wps-paper-wrapper');
                    if(wrapper) wrapper.scrollTop = 0;
                }, 50);
            }
        }

        function showEditor() {
            document.getElementById('list-surat-buat-view').style.display = 'none';
            document.getElementById('editor-surat-buat-view').style.display = 'block';
            document.getElementById('editor-view-title').innerText = 'Buat Surat Resmi Baru';
            document.getElementById('surat-buat-form').action = "{{ route('operasional.surat-buat.store') }}";
            document.getElementById('sb-method-field').value = 'POST';
            document.getElementById('surat-buat-form').reset();
            document.getElementById('sb_is_draft').value = '0';
            
            window.pendingEditorContent = '';
            initTinyMCE();
            syncLiveKop();
        }

        function hideEditor() {
            document.getElementById('list-surat-buat-view').style.display = 'block';
            document.getElementById('editor-surat-buat-view').style.display = 'none';
        }

        function syncLiveKop() {
            document.getElementById('live-kop-title').innerText = document.getElementById('sb_header_title').value;
            document.getElementById('live-kop-subtitle').innerText = document.getElementById('sb_header_subtitle').value;
        }

        function changePaperZoom() {
            const zoomLevel = document.getElementById('paper-zoom').value;
            document.getElementById('wps-paper-sheet').style.zoom = zoomLevel;
            
            // Re-focus editor so the toolbar reappears automatically
            if (typeof tinymce !== 'undefined' && tinymce.get('quill-editor')) {
                tinymce.get('quill-editor').focus();
            }
        }

        function changePaperSize() {
            const size = document.getElementById('paper-size').value;
            const paper = document.getElementById('wps-paper-sheet');
            let height = '297mm';
            let width = '210mm';
            
            if (size === 'F4') { height = '330mm'; width = '215.9mm'; }
            if (size === 'Letter') { height = '279.4mm'; width = '215.9mm'; }
            
            paper.style.maxWidth = width;
            paper.style.minHeight = height;
            paper.style.backgroundImage = 'none';
            
            if (typeof tinymce !== 'undefined' && tinymce.get('quill-editor')) {
                tinymce.get('quill-editor').focus();
            }
        }

        function editSuratBuat(sb) {
            document.getElementById('list-surat-buat-view').style.display = 'none';
            document.getElementById('editor-surat-buat-view').style.display = 'block';
            document.getElementById('editor-view-title').innerText = 'Edit Surat Resmi';
            
            const form = document.getElementById('surat-buat-form');
            form.action = "{{ route('operasional.surat-buat.update', ':id') }}".replace(':id', sb.id);
            document.getElementById('sb-method-field').value = 'PUT';

            document.getElementById('sb_template_key').value = sb.template_key;
            document.getElementById('sb_header_title').value = sb.header_title;
            document.getElementById('sb_header_subtitle').value = sb.header_subtitle || '';
            document.getElementById('sb_nomor_surat').value = sb.nomor_surat;
            document.getElementById('sb_perihal').value = sb.perihal;
            
            const dateStr = sb.tanggal_surat ? sb.tanggal_surat.split('T')[0] : '';
            document.getElementById('sb_tanggal_surat').value = dateStr;
            document.getElementById('sb_tujuan_surat').value = sb.tujuan_surat || '';
            
            document.getElementById('sb_nama_sekretaris').value = sb.nama_sekretaris || '';
            document.getElementById('sb_nama_ketua').value = sb.nama_ketua || '';
            document.getElementById('sb_nama_penasehat').value = sb.nama_penasehat || '';
            document.getElementById('sb_is_draft').value = sb.is_draft ? '1' : '0';

            // Load HTML content into TinyMCE
            window.pendingEditorContent = sb.isi_surat || '';
            initTinyMCE();
            syncLiveKop();
        }

        // On submitting the letter creation form, pull html from TinyMCE
        const sbForm = document.getElementById('surat-buat-form');
        if (sbForm) {
            sbForm.addEventListener('submit', function(e) {
                if (tinymce.get('quill-editor')) {
                    document.getElementById('sb-isi-surat').value = tinymce.get('quill-editor').getContent();
                }
            });
        }

        // Predefined templates injection
        function applyLetterTemplate() {
            const tempKey = document.getElementById('sb_template_key').value;
            let content = '';

            if (tempKey === 'undangan') {
                content = `
                    <p>Dengan hormat,</p>
                    <p>Sehubungan dengan akan diadakannya rapat koordinasi penting pengurus takmir, kami mengharapkan kehadiran Bapak/Ibu/Saudara pada:</p>
                    <p style="margin-left: 20px;">
                        <strong>Hari / Tanggal:</strong> [Hari / Tanggal]<br>
                        <strong>Waktu:</strong> 19.30 WIB (Ba'da Isya) s/d Selesai<br>
                        <strong>Tempat:</strong> Ruang Pertemuan Masjid Baginda<br>
                        <strong>Agenda:</strong> Evaluasi Program Kerja Bulanan Takmir
                    </p>
                    <p>Mengingat pentingnya acara ini, kehadiran Bapak/Ibu sekalian sangat kami harapkan. Semoga Allah SWT memudahkan langkah kita.</p>
                    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
                `;
            } else if (tempKey === 'tugas') {
                content = `
                    <p style="text-align: center;"><strong><u>SURAT TUGAS</u></strong><br>Nomor: [Nomor_Surat]</p>
                    <p style="margin-top: 15px;">Yang bertanda tangan di bawah ini, Pengurus Takmir Masjid Baginda memberikan tugas delegasi kepada:</p>
                    <p style="margin-left: 20px;">
                        <strong>Nama:</strong> [Nama Penerima Tugas]<br>
                        <strong>Jabatan:</strong> [Jabatan]<br>
                        <strong>Alamat:</strong> [Alamat]
                    </p>
                    <p>Untuk menghadiri/melaksanakan agenda [Deskripsi Tugas] mewakili Takmir Masjid Baginda yang diselenggarakan pada [Hari/Tanggal] di [Lokasi Acara].</p>
                    <p>Demikian surat tugas ini diberikan agar dilaksanakan dengan penuh amanah, dedikasi, dan penuh tanggung jawab.</p>
                `;
            } else if (tempKey === 'keputusan') {
                content = `
                    <p style="text-align: center;"><strong><u>SURAT KEPUTUSAN</u></strong><br>Nomor: [Nomor_Surat]</p>
                    <p style="text-align: center; margin-top: 10px; margin-bottom: 15px;">TENTANG<br><strong>PENGANGKATAN PANITIA KEGIATAN MASJID BAGINDA</strong></p>
                    <p><strong>Menimbang:</strong> Bahwa demi kelancaran program ibadah dan kemakmuran masjid, maka dipandang perlu untuk membentuk kepanitiaan pelaksana.</p>
                    <p><strong>Mengingat:</strong> Hasil keputusan rapat harian takmir Masjid Baginda pada tanggal [Tanggal Rapat].</p>
                    <p style="text-align: center; font-weight: bold; margin: 15px 0;">MEMUTUSKAN</p>
                    <p><strong>Menetapkan:</strong> Mengangkat nama-nama yang tercantum di lampiran sebagai panitia pelaksana kegiatan.</p>
                    <p>Keputusan ini berlaku sejak tanggal ditetapkan dan apabila di kemudian hari terdapat kekeliruan akan diadakan perbaikan sebagaimana mestinya.</p>
                `;
            }

            if (tinymce.get('quill-editor')) {
                if (content !== '') {
                    // Replace placeholder [Nomor_Surat] with actual input
                    const currentNo = document.getElementById('sb_nomor_surat').value;
                    content = content.replaceAll('[Nomor_Surat]', currentNo);
                    tinymce.get('quill-editor').setContent(content);
                } else {
                    tinymce.get('quill-editor').setContent('');
                }
            }
        }

        // --- SIGNATURES & TTE PAD DIALOG LOGIC ---
        let currentLetterIdForSign = null;
        let currentRoleForSign = null;

        function openSignatureModal(sb) {
            currentLetterIdForSign = sb.id;
            
            // Set Signatures Status inside modal
            setupTteBox('sekretaris', sb.status_sekretaris, sb.ttd_sekretaris, sb.nama_sekretaris);
            setupTteBox('ketua', sb.status_ketua, sb.ttd_ketua, sb.nama_ketua);
            setupTteBox('penasehat', sb.status_penasehat, sb.ttd_penasehat, sb.nama_penasehat);

            document.getElementById('tte-modal').classList.add('open');
        }

        function closeSignatureModal() {
            document.getElementById('tte-modal').classList.remove('open');
            // Refresh page to show updated TTE status in table
            window.location.reload();
        }

        const loggedInUserRole = "{{ $hakakses->nama_hakakses }}";
        const loggedInUserPosition = "{{ strtolower($userTakmir?->jabatan ?? '') }}";

        function setupTteBox(role, status, ttdPath, name) {
            const statusBox = document.getElementById(`status-${role}-box`);
            const container = document.getElementById(`img-${role}-container`);
            const btn = document.getElementById(`btn-sign-${role}`);

            // Enforce signing permission based on position link
            let hasSignPermission = false;
            if (loggedInUserRole === 'administrator') {
                hasSignPermission = true;
            } else {
                if (role === 'sekretaris' && loggedInUserPosition.includes('sekretaris')) {
                    hasSignPermission = true;
                } else if (role === 'ketua' && loggedInUserPosition.includes('ketua')) {
                    hasSignPermission = true;
                } else if (role === 'penasehat' && (loggedInUserPosition.includes('penasehat') || loggedInUserPosition.includes('penasihat'))) {
                    hasSignPermission = true;
                }
            }

            if (status === 'signed') {
                statusBox.innerHTML = '<span class="badge badge-disetujui">Sudah TTD</span>';
                container.innerHTML = `<img src="${ttdPath}" class="tte-img" alt="TTD"><div style="font-size:12px; font-weight:600; color:#334155;">${name || ''}</div>`;
                btn.innerText = 'Tanda Tangani Ulang';
            } else {
                statusBox.innerHTML = '<span class="badge badge-pending">Belum TTD</span>';
                container.innerHTML = '<div style="height:50px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-style:italic; font-size:12px;">Kosong</div>';
                btn.innerText = 'Tanda Tangani';
            }

            if (hasSignPermission) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.title = '';
            } else {
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
                btn.title = `Hanya dapat ditandatangani oleh ${role.toUpperCase()} Takmir (Akun Anda terhubung sebagai: ${loggedInUserPosition || 'Bukan Pengurus Takmir'})`;
            }
        }

        function startSigning(role) {
            currentRoleForSign = role;
            
            // Set default name placeholder in input
            let defaultName = '';
            if (role === 'sekretaris') defaultName = document.getElementById('sb_nama_sekretaris').value;
            else if (role === 'ketua') defaultName = document.getElementById('sb_nama_ketua').value;
            else if (role === 'penasehat') defaultName = document.getElementById('sb_nama_penasehat').value;
            
            document.getElementById('nama_penandatangan_input').value = defaultName;
            document.getElementById('sig-pad-title').innerText = `Bubuhkan TTE: ${role.toUpperCase()}`;
            
            document.getElementById('sig-pad-modal').classList.add('open');
        }

        function closeSigPad() {
            document.getElementById('sig-pad-modal').classList.remove('open');
        }

        function saveSignature() {
            const name = document.getElementById('nama_penandatangan_input').value;
            if (!name) {
                alert('Nama penandatangan wajib diisi!');
                return;
            }

            const signUrl = "{{ route('operasional.surat-buat.sign', ':id') }}".replace(':id', currentLetterIdForSign);

            // Send to server via AJAX
            fetch(signUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    role: currentRoleForSign,
                    nama_penandatangan: name
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeSigPad();
                    
                    // Update current modal view
                    setupTteBox(currentRoleForSign, 'signed', data.qr_code_url, name);
                } else {
                    alert('Gagal menyematkan TTE.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            });
        }
    </script>

</body>
</html>
