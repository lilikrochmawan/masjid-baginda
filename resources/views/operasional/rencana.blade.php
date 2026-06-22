<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rencana Kerja Seksi - Baginda</title>
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

        /* ── Rencana Cards / Lists ── */
        .rencana-card { background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0; padding: 18px; margin-bottom: 16px; position: relative; transition: all 0.2s; }
        .rencana-card:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16,185,129,0.06); border-color: #cbd5e1; }
        .rencana-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px; }
        .rencana-title { font-size: 15px; font-weight: 700; color: #1e293b; }
        .rencana-pic { font-size: 12px; color: #059669; font-weight: 600; margin-top: 2px; }
        .rencana-desc { font-size: 13px; color: #475569; margin-bottom: 12px; line-height: 1.5; }
        
        .rencana-meta { display: flex; gap: 16px; font-size: 12px; color: #64748b; border-top: 1px solid #f1f5f9; padding-top: 12px; flex-wrap: wrap; }
        .rencana-meta strong { color: #334155; }
        
        .badge { display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .badge-belum_mulai { background: #e2e8f0; color: #475569; }
        .badge-sedang_berjalan { background: #e6f4ed; color: #059669; }
        .badge-selesai { background: #dcfce7; color: #15803d; }
        .badge-dibatalkan { background: #fee2e2; color: #b91c1c; }

        /* ── Progress Bar ── */
        .progress-bar-container { background: #e2e8f0; height: 6px; border-radius: 3px; width: 100%; margin-top: 8px; overflow: hidden; }
        .progress-bar { height: 100%; border-radius: 3px; transition: width 0.3s ease; }
        .progress-belum_mulai { width: 0%; background: #94a3b8; }
        .progress-sedang_berjalan { width: 50%; background: #10b981; }
        .progress-selesai { width: 100%; background: #059669; }
        .progress-dibatalkan { width: 100%; background: #dc2626; }

        .card-actions { position: absolute; right: 18px; bottom: 12px; display: flex; gap: 6px; }

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
            <a href="{{ route('operasional.struktur.index') }}">
                <span class="nav-icon">👥</span> Struktur Takmir
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.inventaris'))
            <a href="{{ route('operasional.inventaris.index') }}">
                <span class="nav-icon">🥫</span> Inventarisasi Barang
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.surat'))
            <a href="{{ route('operasional.surat.index') }}">
                <span class="nav-icon">✉️</span> Surat & Proposal
            </a>
            @endif
            @if(auth()->user()->hasAccess('operasional.rencana'))
            <a href="{{ route('operasional.rencana.index') }}" class="active">
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
        <span class="topbar-brand">Rencana Kerja</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Rencana Kerja Masing-Masing Seksi</h1>
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
                <h2 id="form-title">Tambah Rencana Program Kerja</h2>
                <form id="rencana-form" action="{{ route('operasional.rencana.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="method-field" name="_method" value="POST">

                    <div class="form-group">
                        <label for="tb_takmir_id">Seksi Penanggung Jawab (PIC)</label>
                        <select id="tb_takmir_id" name="tb_takmir_id" required>
                            <option value="">Pilih pengurus...</option>
                            @foreach($takmirs as $t)
                                <option value="{{ $t->id }}">{{ $t->nama }} ({{ $t->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_program">Nama Program Kerja</label>
                        <input type="text" id="nama_program" name="nama_program" required placeholder="Contoh: Renovasi Tempat Wudhu, Pengajian Bulanan">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Program Kerja</label>
                        <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan keterangan detail program kerja"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="anggaran">Anggaran yang Dibutuhkan (Rp)</label>
                        <input type="number" id="anggaran" name="anggaran" required min="0" placeholder="Contoh: 5000000" value="0">
                    </div>

                    <div class="form-group">
                        <label for="target_selesai">Target Tanggal Selesai</label>
                        <input type="date" id="target_selesai" name="target_selesai" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status Pelaksanaan</label>
                        <select id="status" name="status" required>
                            <option value="belum_mulai">Belum Mulai</option>
                            <option value="sedang_berjalan">Sedang Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="button-primary" id="btn-submit">Simpan Program Kerja</button>
                    <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right: List / Cards -->
            <div class="section">
                <h2>Daftar Program Kerja Seksi</h2>
                <div style="margin-top: 15px; max-height: 70vh; overflow-y: auto; padding-right: 6px;">
                    @forelse($rencanas as $r)
                        <div class="rencana-card">
                            <div class="rencana-header">
                                <div>
                                    <div class="rencana-title">{{ $r->nama_program }}</div>
                                    <div class="rencana-pic">🧑‍💼 PIC: {{ $r->penanggungJawab->nama }} ({{ $r->penanggungJawab->jabatan }})</div>
                                </div>
                                <span class="badge badge-{{ $r->status }}">{{ str_replace('_', ' ', $r->status) }}</span>
                            </div>
                            
                            <div class="rencana-desc">
                                {{ $r->deskripsi ?? 'Tidak ada deskripsi detail.' }}
                            </div>

                            <!-- Progress Indicator -->
                            <div style="margin-bottom: 12px;">
                                <div style="display:flex; justify-content:space-between; font-size:11px; color:#64748b;">
                                    <span>Kemajuan Program</span>
                                    <strong>
                                        @if($r->status === 'belum_mulai') 0%
                                        @elseif($r->status === 'sedang_berjalan') 50%
                                        @elseif($r->status === 'selesai') 100%
                                        @else Dibatalkan
                                        @endif
                                    </strong>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar progress-{{ $r->status }}"></div>
                                </div>
                            </div>

                            <div class="rencana-meta">
                                <span>Anggaran: <strong>Rp {{ number_format($r->anggaran, 0, ',', '.') }}</strong></span>
                                <span>Target Selesai: <strong>{{ date('d M Y', strtotime($r->target_selesai)) }}</strong></span>
                            </div>

                            <!-- Card Actions -->
                            <div class="card-actions">
                                <button class="btn-action" onclick='editRencana(@json($r))'>Ubah</button>
                                <form action="{{ route('operasional.rencana.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana program kerja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="text-align:center; padding:30px; color:#94a3b8;">Belum ada rencana kerja seksi terdaftar.</p>
                    @endforelse
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

        // CRUD JS
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('form-title');
        const form = document.getElementById('rencana-form');
        const methodField = document.getElementById('method-field');
        const submitBtn = document.getElementById('btn-submit');
        const cancelBtn = document.getElementById('btn-cancel');

        const picSelect = document.getElementById('tb_takmir_id');
        const programInput = document.getElementById('nama_program');
        const descInput = document.getElementById('deskripsi');
        const anggaranInput = document.getElementById('anggaran');
        const targetInput = document.getElementById('target_selesai');
        const statusSelect = document.getElementById('status');

        function editRencana(r) {
            formContainer.scrollIntoView({ behavior: 'smooth' });

            formTitle.textContent = "Ubah Rencana Program Kerja";
            form.action = "{{ route('operasional.rencana.update', ':id') }}".replace(':id', r.id);
            methodField.value = "PUT";
            submitBtn.textContent = "Simpan Perubahan";
            cancelBtn.style.display = "inline-block";

            picSelect.value = r.tb_takmir_id;
            programInput.value = r.nama_program;
            descInput.value = r.deskripsi || "";
            anggaranInput.value = r.anggaran;
            targetInput.value = r.target_selesai;
            statusSelect.value = r.status;
        }

        function resetForm() {
            formTitle.textContent = "Tambah Rencana Program Kerja";
            form.action = "{{ route('operasional.rencana.store') }}";
            methodField.value = "POST";
            submitBtn.textContent = "Simpan Program Kerja";
            cancelBtn.style.display = "none";
            
            form.reset();
            targetInput.value = "{{ date('Y-m-d') }}";
            anggaranInput.value = "0";
        }
    </script>
</body>
</html>
