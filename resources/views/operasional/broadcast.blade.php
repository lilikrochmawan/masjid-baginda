<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broadcast Pengumuman Takmir - Baginda</title>
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

        /* Tabs Header */
        .tabs-header { display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 2px solid #e2e8f0; padding-bottom: 2px; }
        .tab-btn { padding: 10px 20px; font-size: 14px; font-weight: 600; color: #64748b; background: none; border: none; cursor: pointer; border-radius: 8px 8px 0 0; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .tab-btn:hover { color: #10b981; background: rgba(16,185,129,0.05); }
        .tab-btn.active { color: #047857; border-bottom-color: #047857; background: white; }

        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .page-title { margin-bottom: 20px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }

        /* Forms & Grid */
        .grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 24px; }
        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(16,185,129,0.06); margin-bottom: 20px; border: 1px solid rgba(16,185,129,0.08); }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #0f172a; background: #fafafa; }
        .form-group textarea { min-height: 120px; resize: vertical; font-family: Courier, monospace; }

        .radio-group { display: flex; gap: 16px; margin: 10px 0; }
        .radio-option { display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #475569; }
        .radio-option input { width: auto; cursor: pointer; }

        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; }
        .button-primary:hover { transform: translateY(-1px); background: #059669; }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #64748b; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 650px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #1e293b; }
        th { background: #f0fdf4; font-weight: 700; color: #0f766e; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #0f766e; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .btn-danger { color: #dc2626; border-color: #fecaca; }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-failed { background: #fee2e2; color: #b91c1c; }

        @media (max-width: 1024px) { .grid { grid-template-columns: 1fr; } }
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
            <a href="{{ route('operasional.surat.index') }}">
                <span class="nav-icon">✉️</span> Persuratan
            </a>
            <a href="{{ route('operasional.broadcast.index') }}" class="active">
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
        <span class="topbar-brand">Pengumuman</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <!-- Tabs Header -->
        <div class="tabs-header">
            <button class="tab-btn active" onclick="switchTab('broadcast-tab')">Broadcast Pengumuman WA</button>
            <button class="tab-btn" onclick="switchTab('templates-tab')">Master Template Pengumuman</button>
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

        <!-- TAB 1: BROADCAST PENGUMUMAN -->
        <div id="broadcast-tab" class="tab-content active">
            <div class="page-title">
                <h1>Broadcast Pengumuman Takmir via WA</h1>
            </div>

            <div class="grid">
                <!-- Left: Form -->
                <div class="section">
                    <h2>Kirim Pengumuman Baru</h2>
                    <form action="{{ route('operasional.broadcast.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="template_select">Pilih Template Pengumuman</label>
                            <select id="template_select" onchange="applyTemplate()">
                                <option value="">-- Pilih Template (Opsional) --</option>
                                @foreach($templates as $t)
                                    <option value="{{ $t->id }}" data-content="{{ $t->isi_template }}">{{ $t->nama_template }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="judul">Judul Pengumuman <span style="font-weight:normal; color:#64748b;">(Untuk catatan laporan)</span></label>
                            <input type="text" id="judul" name="judul" required placeholder="Contoh: Rapat Koordinasi Bulan Juli 2026">
                        </div>

                        <div class="form-group">
                            <label>Target Penerima</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="target_type" value="semua_takmir" checked onclick="handleTargetChange()">
                                    Semua Takmir ({{ count($takmirs) }} Orang)
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="target_type" value="grup_wa" onclick="handleTargetChange()">
                                    Grup WhatsApp
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="target_type" value="custom" onclick="handleTargetChange()">
                                    Nomor Kustom
                                </label>
                            </div>
                        </div>

                        <!-- Target Detail Input (Hidden for Semua Takmir) -->
                        <div class="form-group" id="target-detail-group" style="display:none;">
                            <label id="target-label" for="target_detail">Target Detail</label>
                            <input type="text" id="target_detail" name="target_detail" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="isi_pengumuman">Isi Pesan WhatsApp</label>
                            <textarea id="isi_pengumuman" name="isi_pengumuman" required placeholder="Tulis pengumuman di sini..."></textarea>
                        </div>

                        <button type="submit" class="button-primary">Kirim Broadcast</button>
                    </form>
                </div>

                <!-- Right: Report Table -->
                <div class="section">
                    <h2>Riwayat Broadcast Pengumuman</h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal & Judul</th>
                                    <th>Target</th>
                                    <th>Terkirim</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($broadcasts as $b)
                                    <tr>
                                        <td>
                                            <div style="font-weight:700; color:#0f4d36;">{{ $b->judul }}</div>
                                            <div style="font-size:11px; color:#64748b; margin-top:2px;">
                                                {{ $b->created_at->format('d M Y H:i') }} | oleh: {{ $b->creator?->name ?? 'Admin' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($b->target_type === 'semua_takmir')
                                                <span class="badge" style="background:#dcfce7; color:#15803d;">Semua Takmir</span>
                                            @elseif($b->target_type === 'grup_wa')
                                                <span class="badge" style="background:#f3e8ff; color:#7e22ce;">Grup WA</span>
                                                <div style="font-size:11px; color:#64748b; margin-top:2px;">ID: {{ $b->target_detail }}</div>
                                            @else
                                                <span class="badge" style="background:#cbd5e1; color:#475569;">Kustom</span>
                                                <div style="font-size:11px; color:#64748b; margin-top:2px; max-width:150px; overflow:hidden; text-overflow:ellipsis;">{{ $b->target_detail }}</div>
                                            @endif
                                        </td>
                                        <td><strong>{{ $b->total_sent }}</strong> No</td>
                                        <td>
                                            @if($b->status === 'success')
                                                <span class="badge badge-success">Sukses</span>
                                            @else
                                                <span class="badge badge-failed">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; color:#64748b; padding:30px 0;">Belum ada riwayat broadcast.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: MASTER TEMPLATE PENGUMUMAN -->
        <div id="templates-tab" class="tab-content">
            <div class="page-title">
                <h1>Master Template Pengumuman</h1>
            </div>

            <div class="grid">
                <!-- Left: Form CRUD -->
                <div class="section" id="template-form-container">
                    <h2 id="template-form-title">Tambah Template Baru</h2>
                    <form id="template-form" action="{{ route('operasional.broadcast-template.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="temp-method-field" name="_method" value="POST">

                        <div class="form-group">
                            <label for="nama_template">Nama Template</label>
                            <input type="text" id="nama_template" name="nama_template" required placeholder="Contoh: Undangan Rapat Takmir">
                        </div>

                        <div class="form-group">
                            <label for="isi_template">Isi Template</label>
                            <textarea id="isi_template" name="isi_template" required placeholder="Format pesan..." style="min-height: 180px;"></textarea>
                        </div>

                        <button type="submit" class="button-primary" id="btn-temp-submit">Simpan Template</button>
                        <button type="button" class="button-secondary" id="btn-temp-cancel" style="display:none;" onclick="resetTemplateForm()">Batal</button>
                    </form>
                </div>

                <!-- Right: Table List -->
                <div class="section">
                    <h2>Daftar Template Pengumuman</h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Template</th>
                                    <th>Isi Template Preview</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $temp)
                                    <tr>
                                        <td style="font-weight:700; color:#0f4d36;">{{ $temp->nama_template }}</td>
                                        <td>
                                            <div style="font-size:12px; color:#475569; max-height:80px; overflow-y:auto; font-family:Courier, monospace; white-space:pre-wrap; background:#f8fafc; padding:8px; border-radius:6px; border:1px solid #e2e8f0;">{{ $temp->isi_template }}</div>
                                        </td>
                                        <td>
                                            <button class="btn-action" onclick="editTemplate({{ json_encode($temp) }})">Edit</button>
                                            <form action="{{ route('operasional.broadcast-template.destroy', $temp->id) }}" method="POST" style="display:inline; margin-left:4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align:center; color:#64748b; padding:30px 0;">Belum ada template pengumuman.</td>
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
            url.searchParams.set('tab', tabId === 'broadcast-tab' ? 'broadcast' : 'templates');
            window.history.pushState({}, '', url);
        }

        // Initialize active tab from URL query params
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam === 'templates') {
                switchTab('templates-tab');
            } else {
                switchTab('broadcast-tab');
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

        // --- BROADCAST TAB FUNCTIONS ---
        function applyTemplate() {
            const select = document.getElementById('template_select');
            const selectedOption = select.options[select.selectedIndex];
            const content = selectedOption.getAttribute('data-content');

            if (content) {
                document.getElementById('isi_pengumuman').value = content;
                document.getElementById('judul').value = selectedOption.text;
            } else {
                document.getElementById('isi_pengumuman').value = '';
                document.getElementById('judul').value = '';
            }
        }

        function handleTargetChange() {
            const targetType = document.querySelector('input[name="target_type"]:checked').value;
            const detailGroup = document.getElementById('target-detail-group');
            const label = document.getElementById('target-label');
            const input = document.getElementById('target_detail');

            if (targetType === 'semua_takmir') {
                detailGroup.style.display = 'none';
                input.required = false;
            } else if (targetType === 'grup_wa') {
                detailGroup.style.display = 'block';
                label.innerText = 'ID Grup WhatsApp (Fonnte)';
                input.placeholder = 'Contoh: 1203630238128@g.us';
                input.required = true;
            } else if (targetType === 'custom') {
                detailGroup.style.display = 'block';
                label.innerText = 'Daftar Nomor WhatsApp (Pisahkan dengan koma atau baris baru)';
                input.placeholder = 'Contoh: 081234567890, 089876543210';
                input.required = true;
            }
        }

        // --- TEMPLATE CRUD FUNCTIONS ---
        function editTemplate(temp) {
            document.getElementById('template-form-title').innerText = 'Edit Template Pengumuman';
            const form = document.getElementById('template-form');
            form.action = "{{ route('operasional.broadcast-template.update', ':id') }}".replace(':id', temp.id);
            document.getElementById('temp-method-field').value = 'PUT';

            document.getElementById('nama_template').value = temp.nama_template;
            document.getElementById('isi_template').value = temp.isi_template;

            document.getElementById('btn-temp-cancel').style.display = 'inline-block';
            document.getElementById('btn-temp-submit').innerText = 'Perbarui Template';
            
            // Scroll to form
            document.getElementById('template-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function resetTemplateForm() {
            document.getElementById('template-form-title').innerText = 'Tambah Template Baru';
            const form = document.getElementById('template-form');
            form.action = "{{ route('operasional.broadcast-template.store') }}";
            document.getElementById('temp-method-field').value = 'POST';
            form.reset();
            document.getElementById('btn-temp-cancel').style.display = 'none';
            document.getElementById('btn-temp-submit').innerText = 'Simpan Template';
        }
    </script>
</body>
</html>
