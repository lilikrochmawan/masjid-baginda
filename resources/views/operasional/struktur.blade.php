<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Takmir - Baginda</title>
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
        .form-group input, .form-group select { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #0f172a; background: #fafafa; }
        
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); background: #059669; }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #64748b; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* ── Tabs Navigation ── */
        .tabs-header { display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 16px; gap: 8px; }
        .tab-btn { padding: 10px 20px; border: none; background: none; font-weight: 600; font-size: 14px; color: #64748b; cursor: pointer; position: relative; bottom: -2px; border-bottom: 2px solid transparent; transition: all 0.2s; }
        .tab-btn:hover { color: #10b981; }
        .tab-btn.active { color: #10b981; border-bottom: 2px solid #10b981; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* ── CSS Tree Organogram ── */
        .tree-wrapper { width: 100%; overflow-x: auto; padding: 20px 0; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; }
        .tree { display: inline-block; min-width: 100%; text-align: center; }
        .tree ul { padding-top: 20px; position: relative; transition: all 0.5s; display: flex; justify-content: center; }
        .tree li { text-align: center; list-style-type: none; position: relative; padding: 20px 10px 0 10px; transition: all 0.5s; }
        .tree li::before, .tree li::after { content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #cbd5e1; width: 50%; height: 20px; }
        .tree li::after { right: auto; left: 50%; border-left: 2px solid #cbd5e1; }
        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 2px solid #cbd5e1; border-radius: 0 5px 0 0; }
        .tree li:first-child::after { border-radius: 5px 0 0 0; }
        .tree ul ul::before { content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #cbd5e1; width: 0; height: 20px; }
        
        .tree .node { border: 2px solid #e2e8f0; padding: 12px 18px; text-decoration: none; display: inline-block; border-radius: 12px; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); text-align: center; min-width: 160px; transition: all 0.3s; }
        .tree .node-jabatan { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #059669; margin-bottom: 4px; letter-spacing: 0.5px; }
        .tree .node-nama { font-size: 13.5px; font-weight: 700; color: #1e293b; }
        .tree .node-hp { font-size: 10px; color: #64748b; margin-top: 4px; }
        
        .tree .node:hover { transform: translateY(-2px); border-color: #10b981; box-shadow: 0 10px 15px -3px rgba(16,185,129,0.15); }
        .tree .node:hover .node-jabatan { color: #10b981; }

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
            <a href="{{ route('operasional.struktur.index') }}" class="active">
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
        <span class="topbar-brand">Struktur Takmir</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Struktur Organisasi Takmir</h1>
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
            <!-- Left: Form -->
            <div class="section" id="form-container">
                <h2 id="form-title">Tambah Pengurus Takmir</h2>
                <form id="takmir-form" action="{{ route('operasional.struktur.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="method-field" name="_method" value="POST">

                    <div class="form-group">
                        <label for="tb_user_id">Tautkan ke Akun Pengguna (tb_user)</label>
                        <select id="tb_user_id" name="tb_user_id" onchange="autoFillNama()">
                            <option value="">-- Belum Ditautkan ke Akun --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" data-name="{{ $u->name }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" required placeholder="Contoh: Ketua, Bendahara, Seksi Ibadah">
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Laporan Ke (Atasan langsung / parent)</label>
                        <select id="parent_id" name="parent_id">
                            <option value="">Tidak ada (Puncak Organisasi)</option>
                            @foreach($parentOptions as $opt)
                                <option value="{{ $opt->id }}">{{ $opt->nama }} - {{ $opt->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No. HP / WhatsApp (opsional)</label>
                        <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789">
                    </div>

                    <div class="form-group">
                        <label for="status">Status Kepengurusan</label>
                        <select id="status" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="non_aktif">Non Aktif</option>
                        </select>
                    </div>

                    <button type="submit" class="button-primary" id="btn-submit">Simpan Anggota</button>
                    <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right: Chart and List Tabs -->
            <div class="section">
                <div class="tabs-header">
                    <button class="tab-btn active" onclick="switchTab('bagan')">Bagan Organisasi</button>
                    <button class="tab-btn" onclick="switchTab('daftar')">Daftar Pengurus</button>
                </div>

                <!-- Tab 1: Organogram Chart -->
                <div id="tab-bagan" class="tab-content active">
                    <div class="tree-wrapper">
                        @php
                            $buildTree = function($parent_id) use (&$buildTree, $takmirs) {
                                $children = $takmirs->where('parent_id', $parent_id)->where('status', 'aktif');
                                if ($children->isEmpty()) return '';
                                
                                $html = '<ul>';
                                foreach ($children as $child) {
                                    $html .= '<li>';
                                    $html .= '<div class="node">';
                                    $html .= '  <div class="node-jabatan">' . e($child->jabatan) . '</div>';
                                    $html .= '  <div class="node-nama">' . e($child->nama) . '</div>';
                                    if ($child->no_hp) {
                                        $html .= '  <div class="node-hp">📱 ' . e($child->no_hp) . '</div>';
                                    }
                                    $html .= '</div>';
                                    $html .= $buildTree($child->id);
                                    $html .= '</li>';
                                }
                                $html .= '</ul>';
                                return $html;
                            };
                            
                            $roots = $takmirs->where('parent_id', null)->where('status', 'aktif');
                        @endphp

                        <div class="tree">
                            @if($roots->isEmpty())
                                <p style="text-align:center; padding: 20px; color:#64748b;">Belum ada anggota kepengurusan aktif.</p>
                            @else
                                <ul>
                                    @foreach($roots as $root)
                                        <li>
                                            <div class="node">
                                                <div class="node-jabatan">{{ $root->jabatan }}</div>
                                                <div class="node-nama">{{ $root->nama }}</div>
                                                @if($root->no_hp)
                                                    <div class="node-hp">📱 {{ $root->no_hp }}</div>
                                                @endif
                                            </div>
                                            {!! $buildTree($root->id) !!}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab 2: CRUD Table -->
                <div id="tab-daftar" class="tab-content">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Laporan Ke</th>
                                    <th>No. HP</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($takmirs as $takmir)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                             <strong>{{ $takmir->nama }}</strong>
                                             @if($takmir->user)
                                                 <div style="font-size:11px; color:#10b981; margin-top:2px;">🔗 User: {{ $takmir->user->name }}</div>
                                             @else
                                                 <div style="font-size:11px; color:#94a3b8; margin-top:2px; font-style:italic;">Belum ditautkan</div>
                                             @endif
                                         </td>
                                        <td>{{ $takmir->jabatan }}</td>
                                        <td>
                                            @if($takmir->parent)
                                                <span style="font-size:12px; color:#0f766e;">👤 {{ $takmir->parent->nama }} ({{ $takmir->parent->jabatan }})</span>
                                            @else
                                                <span style="font-size:12px; color:#94a3b8; font-style:italic;">Puncak</span>
                                            @endif
                                        </td>
                                        <td>{{ $takmir->no_hp ?? '-' }}</td>
                                        <td>
                                            @if($takmir->status === 'aktif')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-warning">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn-action" onclick='editTakmir(@json($takmir))'>Ubah</button>
                                            <form action="{{ route('operasional.struktur.destroy', $takmir->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengurus ini? Struktur bawahan pengurus ini akan dilepaskan (parent set null).')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; color:#94a3b8;">Belum ada data pengurus.</td>
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

        // Tab Switcher
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            const activeBtn = Array.from(document.querySelectorAll('.tab-btn')).find(btn => btn.textContent.toLowerCase().includes(tabId === 'bagan' ? 'bagan' : 'daftar'));
            if(activeBtn) activeBtn.classList.add('active');
            
            const activeContent = document.getElementById('tab-' + tabId);
            if(activeContent) activeContent.classList.add('active');
        }

        // CRUD JS
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('form-title');
        const form = document.getElementById('takmir-form');
        const methodField = document.getElementById('method-field');
        const submitBtn = document.getElementById('btn-submit');
        const cancelBtn = document.getElementById('btn-cancel');

        const userIdSelect = document.getElementById('tb_user_id');
        const namaInput = document.getElementById('nama');
        const jabatanInput = document.getElementById('jabatan');
        const parentSelect = document.getElementById('parent_id');
        const noHpInput = document.getElementById('no_hp');
        const statusSelect = document.getElementById('status');

        function autoFillNama() {
            const selectedOpt = userIdSelect.options[userIdSelect.selectedIndex];
            const name = selectedOpt.getAttribute('data-name');
            if (name) {
                namaInput.value = name;
            }
        }

        function editTakmir(takmir) {
            formContainer.scrollIntoView({ behavior: 'smooth' });

            formTitle.textContent = "Ubah Data Pengurus";
            form.action = "{{ route('operasional.struktur.update', ':id') }}".replace(':id', takmir.id);
            methodField.value = "PUT";
            submitBtn.textContent = "Simpan Perubahan";
            cancelBtn.style.display = "inline-block";

            userIdSelect.value = takmir.tb_user_id || "";
            namaInput.value = takmir.nama;
            jabatanInput.value = takmir.jabatan;
            parentSelect.value = takmir.parent_id || "";
            noHpInput.value = takmir.no_hp || "";
            statusSelect.value = takmir.status;
            
            // Exclude self from parent option
            Array.from(parentSelect.options).forEach(opt => {
                if(opt.value == takmir.id) {
                    opt.disabled = true;
                } else {
                    opt.disabled = false;
                }
            });
        }

        function resetForm() {
            formTitle.textContent = "Tambah Pengurus Takmir";
            form.action = "{{ route('operasional.struktur.store') }}";
            methodField.value = "POST";
            submitBtn.textContent = "Simpan Anggota";
            cancelBtn.style.display = "none";
            form.reset();
            userIdSelect.value = "";
            
            Array.from(parentSelect.options).forEach(opt => opt.disabled = false);
        }
    </script>
</body>
</html>
