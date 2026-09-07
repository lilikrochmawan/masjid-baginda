<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Santri TPQ - Baginda</title>
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
        .form-group input, .form-group select { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; }
        .form-group input[readonly] { background: #eef7f4; color: #5c7b73; cursor: not-allowed; border-color: #c3e2d5; }
        
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #6b7280; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 800px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
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
<a href="{{ route('tpq.santri.index') }}" class="active">
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
        <span class="topbar-brand">Data Santri TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Manajemen Data Santri</h1>
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
            <!-- Left Side: Form -->
            <div class="section" id="form-container">
                <h2 id="form-title">Pendaftaran Santri Baru</h2>
                <form id="santri-form" action="{{ route('tpq.santri.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="method-field" name="_method" value="POST">

                    <div class="form-group">
                        <label for="nis">NIS (Nomor Induk Santri) <span style="font-weight: normal; color: #059669; font-size: 12px; margin-left: 4px;">(Otomatis)</span></label>
                        <input type="text" id="nis" name="nis" value="{{ $nextNis }}" readonly placeholder="Masukkan NIS santri">
                    </div>

                    <div class="form-group">
                        <label for="nama_santri">Nama Lengkap Santri</label>
                        <input type="text" id="nama_santri" name="nama_santri" required placeholder="Masukkan nama santri">
                    </div>

                    <div class="form-group">
                        <label for="tb_kelas_id">Pilih Kelas</label>
                        <select id="tb_kelas_id" name="tb_kelas_id">
                            <option value="">Tanpa Kelas (Belum Ditempatkan)</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                    </div>

                    <div class="form-group">
                        <label for="alamat_rumah">Alamat Rumah</label>
                        <input type="text" id="alamat_rumah" name="alamat_rumah" placeholder="Masukkan alamat rumah">
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" placeholder="Masukkan nama ayah">
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" placeholder="Masukkan nama ibu">
                    </div>

                    <div class="form-group">
                        <label for="no_hp_orang_tua">No. HP Orang Tua / Wali</label>
                        <input type="text" id="no_hp_orang_tua" name="no_hp_orang_tua" placeholder="Masukkan nomor handphone orang tua">
                    </div>

                    <button type="submit" class="button-primary" id="btn-submit">Simpan Santri</button>
                    <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right Side: Table -->
            <div class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px;">
                    <h2 style="margin-bottom: 0;">Daftar Santri Terdaftar</h2>
                    <form action="{{ route('tpq.santri.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; margin: 0;">
                        <label for="filter_kelas_id" style="font-size: 13.5px; font-weight: 600; color: #164a3f;">Filter Kelas:</label>
                        <select name="kelas_id" id="filter_kelas_id" onchange="this.form.submit()" style="padding: 10px 14px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; cursor: pointer; min-width: 160px; outline: none; transition: border-color 0.2s;">
                            <option value="">Semua Kelas</option>
                            <option value="none" {{ (isset($selectedKelasId) && $selectedKelasId === 'none') ? 'selected' : '' }}>Tanpa Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ (isset($selectedKelasId) && $selectedKelasId == $k->id) ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>L/P</th>
                                <th>Tgl. Lahir</th>
                                <th>Alamat</th>
                                <th>Ayah</th>
                                <th>Ibu</th>
                                <th>No. HP Wali</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($santris as $santri)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $santri->nis ?? '-' }}</td>
                                    <td><strong>{{ $santri->nama_santri }}</strong></td>
                                    <td>
                                        @if($santri->kelas)
                                            <span style="color:#0f766e; font-weight:600;">🏫 {{ $santri->kelas->nama_kelas }}</span>
                                        @else
                                            <span style="color:#9ca3af; font-style:italic;">Belum masuk kelas</span>
                                        @endif
                                    </td>
                                    <td>{{ $santri->jenis_kelamin }}</td>
                                    <td>{{ $santri->tanggal_lahir ? date('d M Y', strtotime($santri->tanggal_lahir)) : '-' }}</td>
                                    <td>{{ $santri->alamat_rumah ?? '-' }}</td>
                                    <td>{{ $santri->nama_ayah ?? '-' }}</td>
                                    <td>{{ $santri->nama_ibu ?? '-' }}</td>
                                    <td>{{ $santri->no_hp_orang_tua ?? '-' }}</td>
                                    <td>
                                        <button class="btn-action" onclick='editSantri(@json($santri))'>Ubah</button>
                                        <form action="{{ route('tpq.santri.destroy', $santri->id) }}" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" style="text-align:center; color:#9ca3af;">Belum ada data santri terdaftar.</td>
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

        // Edit Santri function
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('form-title');
        const form = document.getElementById('santri-form');
        const methodField = document.getElementById('method-field');
        const submitBtn = document.getElementById('btn-submit');
        const cancelBtn = document.getElementById('btn-cancel');

        const nisInput = document.getElementById('nis');
        const namaInput = document.getElementById('nama_santri');
        const kelasIdSelect = document.getElementById('tb_kelas_id');
        const jkSelect = document.getElementById('jenis_kelamin');
        const tglLahirInput = document.getElementById('tanggal_lahir');
        const alamatInput = document.getElementById('alamat_rumah');
        const ayahInput = document.getElementById('nama_ayah');
        const ibuInput = document.getElementById('nama_ibu');
        const noHpOrtuInput = document.getElementById('no_hp_orang_tua');

        function editSantri(santri) {
            // Scroll to form
            formContainer.scrollIntoView({ behavior: 'smooth' });

            formTitle.textContent = "Edit Data Santri";
            form.action = "{{ route('tpq.santri.update', ':id') }}".replace(':id', santri.id);
            methodField.value = "PUT";
            submitBtn.textContent = "Simpan Perubahan";
            cancelBtn.style.display = "inline-block";

            // Fill inputs
            nisInput.value = santri.nis || "";
            namaInput.value = santri.nama_santri;
            kelasIdSelect.value = santri.tb_kelas_id || "";
            jkSelect.value = santri.jenis_kelamin;
            tglLahirInput.value = santri.tanggal_lahir || "";
            alamatInput.value = santri.alamat_rumah || "";
            ayahInput.value = santri.nama_ayah || "";
            ibuInput.value = santri.nama_ibu || "";
            noHpOrtuInput.value = santri.no_hp_orang_tua || "";
        }

        function resetForm() {
            formTitle.textContent = "Pendaftaran Santri Baru";
            form.action = "{{ route('tpq.santri.store') }}";
            methodField.value = "POST";
            submitBtn.textContent = "Simpan Santri";
            cancelBtn.style.display = "none";

            // Reset inputs
            form.reset();
        }
    </script>
</body>
</html>
