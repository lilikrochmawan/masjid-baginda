<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrasi Persuratan & Proposal - Baginda</title>
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

        /* ── Filter bar ── */
        .filter-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 12px; flex-wrap: wrap; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px; }
        .filter-bar select { padding: 8px 12px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fafafa; color: #0f766e; cursor: pointer; outline: none; }

        /* ── Table Layout ── */
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
        .badge-masuk { background: #e6f4ed; color: #059669; }
        .badge-keluar { background: #f3e8ff; color: #7e22ce; }
        .badge-proposal { background: #fef3c7; color: #d97706; }
        
        .badge-pending { background: #cbd5e1; color: #475569; }
        .badge-disetujui { background: #dcfce7; color: #15803d; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }

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
            <a href="{{ route('operasional.surat.index') }}" class="active">
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
        <span class="topbar-brand">Persuratan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Administrasi Persuratan & Proposal</h1>
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
                        <label for="nomor_surat">Nomor Surat / Proposal</label>
                        <input type="text" id="nomor_surat" name="nomor_surat" required placeholder="Contoh: 120/TKM-MB/VI/2026">
                    </div>

                    <div class="form-group">
                        <label for="perihal">Perihal / Subject</label>
                        <input type="text" id="perihal" name="perihal" required placeholder="Contoh: Permohonan Bantuan Dana Ramadhan">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_surat">Tanggal Surat</label>
                        <input type="date" id="tanggal_surat" name="tanggal_surat" required value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Show for Masuk & Proposal -->
                    <div class="form-group" id="group-tgl-diterima">
                        <label for="tanggal_diterima">Tanggal Diterima</label>
                        <input type="date" id="tanggal_diterima" name="tanggal_diterima" value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Show for Masuk & Proposal -->
                    <div class="form-group" id="group-pengirim">
                        <label for="pengirim">Pengirim / Pengaju</label>
                        <input type="text" id="pengirim" name="pengirim" placeholder="Contoh: Panitia PHBI, Remaja Masjid">
                    </div>

                    <!-- Show for Keluar -->
                    <div class="form-group" id="group-penerima" style="display:none;">
                        <label for="penerima">Penerima Surat</label>
                        <input type="text" id="penerima" name="penerima" placeholder="Contoh: Lurah, Bpk. Donatur">
                    </div>

                    <!-- Show for Proposal only -->
                    <div class="form-group" id="group-status-proposal" style="display:none;">
                        <label for="status_proposal">Status Verifikasi Proposal</label>
                        <select id="status_proposal" name="status_proposal">
                            <option value="pending">Pending</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file_dokumen">Upload Berkas / Lampiran <span style="font-weight:normal; font-size:12px; color:#64748b;">(PDF, Gambar, Max 5MB, opsional)</span></label>
                        <input type="file" id="file_dokumen" name="file_dokumen" accept="application/pdf,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <div id="file-helper" style="font-size:11px; color:#059669; margin-top:4px; display:none;"></div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan / Catatan Tambahan (opsional)</label>
                        <textarea id="keterangan" name="keterangan" placeholder="Masukkan catatan tambahan jika ada"></textarea>
                    </div>

                    <button type="submit" class="button-primary" id="btn-submit">Simpan Dokumen</button>
                    <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right: Table -->
            <div class="section">
                <div class="filter-bar">
                    <h2>Arsip Dokumen</h2>
                    <div>
                        <label for="filter_tipe" style="font-size:12px; font-weight:700; color:#64748b; margin-right:6px;">TIPE:</label>
                        <select id="filter_tipe" onchange="filterSurat()">
                            <option value="semua">Semua</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                            <option value="proposal">Proposal</option>
                        </select>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No. Surat / Perihal</th>
                                <th>Tipe</th>
                                <th>Pihak Terkait</th>
                                <th>Tgl Surat</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="surat-table-body">
                            @forelse($surats as $s)
                                <tr class="surat-row" data-tipe="{{ $s->tipe }}">
                                    <td>
                                        <strong>{{ $s->perihal }}</strong><br>
                                        <span style="font-size:11px; color:#64748b;">No: {{ $s->nomor_surat }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $s->tipe }}">{{ $s->tipe }}</span>
                                        @if($s->tipe === 'proposal')
                                            <br>
                                            <span class="badge badge-{{ $s->status_proposal ?? 'pending' }}" style="margin-top: 4px; font-size:9px; padding:2px 6px;">{{ $s->status_proposal ?? 'pending' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->tipe === 'keluar')
                                            <span style="font-size:12px; color:#64748b;">Kepada:</span><br><strong>{{ $s->penerima ?? '-' }}</strong>
                                        @else
                                            <span style="font-size:12px; color:#64748b;">Dari:</span><br><strong>{{ $s->pengirim ?? '-' }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($s->tanggal_surat)) }}
                                    </td>
                                    <td>
                                        @if($s->file_path)
                                            <a href="{{ asset('storage/' . $s->file_path) }}" target="_blank" class="btn-action">Lihat Berkas</a>
                                        @else
                                            <span style="font-size:12px; color:#94a3b8; font-style:italic;">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn-action" onclick='editSurat(@json($s))'>Ubah</button>
                                        <form action="{{ route('operasional.surat.destroy', $s->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data surat/proposal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; color:#94a3b8;">Belum ada arsip surat terdaftar.</td>
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

        // Form conditional fields display logic
        const tipeSelect = document.getElementById('tipe');
        const groupTglDiterima = document.getElementById('group-tgl-diterima');
        const groupPengirim = document.getElementById('group-pengirim');
        const groupPenerima = document.getElementById('group-penerima');
        const groupStatusProposal = document.getElementById('group-status-proposal');

        const inputTglDiterima = document.getElementById('tanggal_diterima');
        const inputPengirim = document.getElementById('pengirim');
        const inputPenerima = document.getElementById('penerima');
        const selectStatusProposal = document.getElementById('status_proposal');

        function handleTipeChange() {
            const val = tipeSelect.value;
            if (val === 'masuk') {
                groupTglDiterima.style.display = 'block';
                groupPengirim.style.display = 'block';
                groupPenerima.style.display = 'none';
                groupStatusProposal.style.display = 'none';
                
                inputPenerima.required = false;
                selectStatusProposal.required = false;
            } else if (val === 'keluar') {
                groupTglDiterima.style.display = 'none';
                groupPengirim.style.display = 'none';
                groupPenerima.style.display = 'block';
                groupStatusProposal.style.display = 'none';

                inputPenerima.required = true;
                selectStatusProposal.required = false;
            } else if (val === 'proposal') {
                groupTglDiterima.style.display = 'block';
                groupPengirim.style.display = 'block';
                groupPenerima.style.display = 'none';
                groupStatusProposal.style.display = 'block';

                inputPenerima.required = false;
                selectStatusProposal.required = true;
            }
        }

        // Initialize form layout
        handleTipeChange();

        // Filter Table by Tipe
        function filterSurat() {
            const filterVal = document.getElementById('filter_tipe').value;
            document.querySelectorAll('.surat-row').forEach(row => {
                const tipe = row.getAttribute('data-tipe');
                if (filterVal === 'semua' || tipe === filterVal) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // CRUD Edit
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('form-title');
        const form = document.getElementById('surat-form');
        const methodField = document.getElementById('method-field');
        const submitBtn = document.getElementById('btn-submit');
        const cancelBtn = document.getElementById('btn-cancel');

        const nomorSuratInput = document.getElementById('nomor_surat');
        const perihalInput = document.getElementById('perihal');
        const tanggalSuratInput = document.getElementById('tanggal_surat');
        const fileHelper = document.getElementById('file-helper');
        const keteranganInput = document.getElementById('keterangan');

        function editSurat(s) {
            formContainer.scrollIntoView({ behavior: 'smooth' });

            formTitle.textContent = "Ubah Catatan Dokumen";
            form.action = "{{ route('operasional.surat.update', ':id') }}".replace(':id', s.id);
            methodField.value = "PUT";
            submitBtn.textContent = "Simpan Perubahan";
            cancelBtn.style.display = "inline-block";

            tipeSelect.value = s.tipe;
            handleTipeChange(); // update form displays

            nomorSuratInput.value = s.nomor_surat;
            perihalInput.value = s.perihal;
            tanggalSuratInput.value = s.tanggal_surat;
            inputTglDiterima.value = s.tanggal_diterima || "";
            inputPengirim.value = s.pengirim || "";
            inputPenerima.value = s.penerima || "";
            selectStatusProposal.value = s.status_proposal || "pending";
            keteranganInput.value = s.keterangan || "";

            if (s.file_path) {
                fileHelper.textContent = "Berkas saat ini: " + s.file_path.split('/').pop() + " (Upload baru untuk mengganti)";
                fileHelper.style.display = 'block';
            } else {
                fileHelper.style.display = 'none';
            }
        }

        function resetForm() {
            formTitle.textContent = "Pencatatan Surat / Proposal";
            form.action = "{{ route('operasional.surat.store') }}";
            methodField.value = "POST";
            submitBtn.textContent = "Simpan Dokumen";
            cancelBtn.style.display = "none";
            fileHelper.style.display = 'none';
            
            form.reset();
            tipeSelect.value = 'masuk';
            handleTipeChange();
            tanggalSuratInput.value = "{{ date('Y-m-d') }}";
            inputTglDiterima.value = "{{ date('Y-m-d') }}";
        }
    </script>
</body>
</html>
