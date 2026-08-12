<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Absensi TPQ - Baginda</title>
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
        
        .filter-row { display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; margin-bottom: 20px; }
        .filter-group { flex: 1; min-width: 200px; }
        .filter-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .filter-group select, .filter-group input { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; }

        .button-primary { display: inline-block; padding: 12px 24px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 14px; }
        .button-primary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            display: block;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 14px 12px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13.5px; color: #164a3f; }
        .table-wrapper th, .table-wrapper td { white-space: nowrap; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        /* ── Radio buttons styling ── */
        .radio-group { display: flex; gap: 14px; }
        .radio-option { display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; }
        .radio-option input[type="radio"] { width: 18px; height: 18px; accent-color: #10b981; cursor: pointer; }
        
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-left: 8px; }
        .badge-H { background: #dcfce7; color: #15803d; }
        .badge-S { background: #fef9c3; color: #a16207; }
        .badge-I { background: #dbeafe; color: #1d4ed8; }
        .badge-A { background: #fee2e2; color: #b91c1c; }

        .keterangan-input { width: 100%; padding: 8px 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; color: #1e293b; background: white; }
        .keterangan-input:focus { border-color: #10b981; outline: none; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .section { padding: 16px 14px; }
            .filter-group { min-width: 100%; }
            th, td { padding: 12px 8px; font-size: 12.5px; }
            .radio-group { gap: 8px; }
            .radio-option { font-size: 12px; gap: 4px; }
            .radio-option input[type="radio"] { width: 16px; height: 16px; }
        }

        /* ── Modal CSS ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; border-radius: 16px; padding: 24px; width: 100%; max-width: 450px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); animation: scaleUp 0.2s ease-out; }
        @keyframes scaleUp { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
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
<a href="{{ route('tpq.absensi.index') }}" class="active">
                <span class="nav-icon">📝</span> Absensi Santri
            </a>
@endif
            @if(auth()->user()->hasAccess('tpq.laporan'))
<a href="{{ route('tpq.laporan.index') }}">
                <span class="nav-icon">📊</span> Laporan Absen
            </a>
@endif
            <a href="{{ route('tpq.prestasi.index') }}">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            @if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator')
            <a href="{{ route('tpq.master-hafalan.index') }}">
                <span class="nav-icon">⚙️</span> Master Hafalan
            </a>
            @endif
            @if(auth()->user()->hasAccess('tpq.keuangan'))
            <a href="{{ route('tpq.keuangan.spp.index') }}" class="{{ request()->routeIs('tpq.keuangan.*') ? 'active' : '' }}">
                <span class="nav-icon">💰</span> Keuangan TPQ
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
        <span class="topbar-brand">Absensi TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Pencatatan Absensi Harian</h1>
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

        <!-- Filter Section -->
        <div class="section">
            <form method="GET" action="{{ route('tpq.absensi.index') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="tb_kelas_id">Pilih Kelas</label>
                        <select id="tb_kelas_id" name="tb_kelas_id" onchange="this.form.submit()">
                            @forelse($classes as $c)
                                <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama_kelas }} (Pengampu: {{ $c->gurus->isNotEmpty() ? $c->gurus->pluck('nama_guru')->implode(', ') : 'Belum ditentukan' }})
                                </option>
                            @empty
                                <option value="">Belum ada kelas tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="tanggal">Pilih Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        <!-- Attendance Sheet Section -->
        @if($selectedClassId)
            <div class="section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 18px; flex-wrap:wrap; gap:10px;">
                    <h2>Daftar Kehadiran Santri</h2>
                    <span style="font-size: 14px; font-weight:600; color:#0f766e; background:#e6f7f0; padding:6px 12px; border-radius:8px;">
                        📅 {{ date('d F Y', strtotime($tanggal)) }}
                    </span>
                </div>

                @if($santris->isNotEmpty())
                    <form id="attendance-form" action="{{ route('tpq.absensi.store') }}" method="POST" onsubmit="confirmSave(event)">
                        @csrf
                        <input type="hidden" name="tb_kelas_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th style="width: 120px;">NIS</th>
                                        <th>Nama Santri</th>
                                        <th style="width: 280px; text-align: center;">Status Kehadiran</th>
                                        <th>Keterangan Tambahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($santris as $santri)
                                        @php
                                            $absen = $existingAbsensi->get($santri->id);
                                            $currentStatus = $absen ? $absen->status : 'H'; // Default Hadir
                                            $currentKeterangan = $absen ? $absen->keterangan : '';
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $santri->nis ?? '-' }}</td>
                                            <td>
                                                <strong>{{ $santri->nama_santri }}</strong>
                                                @if($absen)
                                                    <span class="status-badge badge-{{ $currentStatus }}">{{ $currentStatus === 'H' ? 'Hadir' : ($currentStatus === 'S' ? 'Sakit' : ($currentStatus === 'I' ? 'Izin' : 'Alpa')) }}</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <div class="radio-group" style="justify-content: center;">
                                                    <label class="radio-option" style="color: #166534;">
                                                        <input type="radio" name="absensi[{{ $santri->id }}]" value="H" {{ $currentStatus === 'H' ? 'checked' : '' }}> H
                                                    </label>
                                                    <label class="radio-option" style="color: #854d0e;">
                                                        <input type="radio" name="absensi[{{ $santri->id }}]" value="S" {{ $currentStatus === 'S' ? 'checked' : '' }}> S
                                                    </label>
                                                    <label class="radio-option" style="color: #1e40af;">
                                                        <input type="radio" name="absensi[{{ $santri->id }}]" value="I" {{ $currentStatus === 'I' ? 'checked' : '' }}> I
                                                    </label>
                                                    <label class="radio-option" style="color: #991b1b;">
                                                        <input type="radio" name="absensi[{{ $santri->id }}]" value="A" {{ $currentStatus === 'A' ? 'checked' : '' }}> A
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan[{{ $santri->id }}]" value="{{ $currentKeterangan }}" placeholder="Catatan opsional..." class="keterangan-input">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="margin-top: 20px; display:flex; justify-content:flex-end;">
                            <button type="submit" class="button-primary">💾 Simpan Data Absensi</button>
                        </div>
                    </form>
                @else
                    <p style="text-align:center; color:#9ca3af; padding: 30px 0;">Belum ada santri terdaftar di kelas ini. Daftarkan santri terlebih dahulu di menu Data Santri.</p>
                @endif
            </div>
        @else
            <div class="section">
                <p style="text-align:center; color:#9ca3af; padding: 20px 0;">Silakan buat kelas terlebih dahulu di menu Data Kelas untuk memulai pencatatan absensi.</p>
            </div>
        @endif
    </main>

    <!-- Modal Konfirmasi Absensi -->
    <div class="modal" id="confirm-modal">
        <div class="modal-content" style="max-width: 420px; text-align: center;">
            <div style="font-size: 50px; margin-bottom: 16px;">📲</div>
            <h3 style="color: #0f4d36; font-size: 18px; margin-bottom: 12px;">Konfirmasi Simpan Absensi</h3>
            <p style="color: #4b5563; font-size: 14px; line-height: 1.5; margin-bottom: 24px;">
                Apakah data absensi yang dimasukkan sudah benar? <br>
                Sistem akan menyimpan data ini dan **mengirimkan notifikasi broadcast WhatsApp** ke wali santri masing-masing.
            </p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <button type="button" class="btn-cancel" onclick="closeConfirmModal()" style="padding: 10px 18px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #475569; font-weight: 600; cursor: pointer; transition: all 0.2s;">Batal</button>
                <button type="button" class="button-primary" onclick="submitAbsensiForm()" style="padding: 10px 18px; border-radius: 8px; background: #10b981; color: white; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s;">Ya, Simpan & Kirim</button>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }

        // Modal Confirmation Logic
        function confirmSave(event) {
            event.preventDefault();
            document.getElementById('confirm-modal').classList.add('open');
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.remove('open');
        }

        // Close modal when clicking outside content
        window.addEventListener('click', function(event) {
            const confirmModal = document.getElementById('confirm-modal');
            if (event.target === confirmModal) {
                closeConfirmModal();
            }
        });

        function submitAbsensiForm() {
            // Disable button to prevent double submit
            const submitBtn = document.querySelector('#confirm-modal .button-primary');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Menyimpan...';
            }
            document.getElementById('attendance-form').submit();
        }
    </script>
</body>
</html>
