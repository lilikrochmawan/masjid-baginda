<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kontrol Prestasi Santri - Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3faf7; overflow-x: hidden; }

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

        .grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 24px; min-width: 0; }
        .section { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 16px rgba(15,60,40,0.06); margin-bottom: 20px; min-width: 0; overflow: hidden; }
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; outline: none; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #10b981; }

        /* Radio Toggle Groups */
        .radio-toggle { display: flex; gap: 10px; margin-bottom: 16px; }
        .radio-toggle label { display: flex; align-items: center; justify-content: center; flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #d1e7dd; cursor: pointer; font-weight: 600; font-size: 13.5px; transition: all 0.2s; color: #164a3f; background: #fbfffe; }
        .radio-toggle input { display: none; }
        .radio-toggle input:checked + label { background: #e6f7f0; border-color: #10b981; color: #059669; box-shadow: 0 0 0 1px #10b981; }
        
        .button-primary { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
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
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 900px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        .table-wrapper th, .table-wrapper td { white-space: nowrap; }
        .table-wrapper td.wrap-column { white-space: normal; min-width: 150px; }
        tr:hover { background: #f3fff8; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; text-decoration: none; font-weight: 700; font-size: 12px; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .btn-danger { color: #dc2626; border-color: #fecaca; }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }

        .badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-sorogan { background: #e0f2fe; color: #0369a1; }
        .badge-hafalan { background: #fef3c7; color: #d97706; }
        .badge-lanjut { background: #dcfce7; color: #15803d; }
        .badge-ulang { background: #fee2e2; color: #b91c1c; }

        .recommend-alert { background: #f0fdf4; border: 1px dashed #6ee7b7; border-radius: 12px; padding: 10px 14px; margin-bottom: 16px; font-size: 12.5px; color: #047857; display: none; align-items: center; gap: 8px; }

        /* Custom searchable dropdown */
        .custom-select-container { position: relative; }
        .custom-select-trigger {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #d1e7dd;
            font-size: 14px;
            color: #103a2d;
            background: #fbfffe;
            cursor: pointer;
            position: relative;
            user-select: none;
            text-align: left;
        }
        .custom-select-trigger::after {
            content: "▼";
            font-size: 10px;
            color: #10b981;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .custom-dropdown-list {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #d1e7dd;
            border-radius: 12px;
            z-index: 1000;
            box-shadow: 0 4px 16px rgba(15,60,40,0.1);
            margin-top: 4px;
            overflow: hidden;
        }
        .dropdown-search-wrapper {
            padding: 8px 10px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .dropdown-search-wrapper input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            outline: none;
        }
        .dropdown-search-wrapper input:focus {
            border-color: #10b981;
        }
        .dropdown-options-wrapper {
            max-height: 200px;
            overflow-y: auto;
        }
        .custom-dropdown-list .dropdown-item {
            padding: 10px 14px;
            cursor: pointer;
            border-bottom: 1px solid #f0fdf4;
            font-size: 13.5px;
            transition: background 0.2s;
            color: #164a3f;
        }
        .custom-dropdown-list .dropdown-item:hover {
            background: #e6f7f0;
        }
        .custom-dropdown-list .dropdown-group-label {
            background: #f0fdf4;
            padding: 6px 12px;
            font-weight: 700;
            font-size: 11px;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e6f4ed;
        }

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
            <a href="{{ route('tpq.prestasi.index') }}" class="active">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            @if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator')
            <a href="{{ route('tpq.master-hafalan.index') }}">
                <span class="nav-icon">⚙️</span> Master Hafalan
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
        <span class="topbar-brand">Kartu Prestasi</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Kartu Kontrol Prestasi Santri</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid">
            <!-- Left Column: Form Input Prestasi -->
            <div class="section">
                <h2>Catat Prestasi Baru</h2>

                <div id="recommendationAlert" class="recommend-alert">
                    <span>💡</span> <span id="recommendationText">Rekomendasi halaman otomatis terisi.</span>
                </div>

                <form action="{{ route('tpq.prestasi.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Pilih Santri</label>
                        <div class="custom-select-container" id="santriSelectContainer">
                            <div id="santriSelectTrigger" class="custom-select-trigger" onclick="toggleSantriDropdown(event)">
                                -- Pilih Santri --
                            </div>
                            
                            <div id="santriDropdownList" class="custom-dropdown-list">
                                <div class="dropdown-search-wrapper">
                                    <input type="text" id="santriSearchInput" placeholder="Cari santri berdasarkan nama / NIS / kelas..." autocomplete="off" oninput="filterSantriDropdown()">
                                </div>
                                <div class="dropdown-options-wrapper">
                                    <div class="dropdown-item option-default" onclick="selectSantri('', '-- Pilih Santri --')">-- Pilih Santri --</div>
                                    
                                    @foreach($santris->groupBy(fn($s) => $s->kelas?->nama_kelas ?? 'Tanpa Kelas') as $namaKelas => $listSantri)
                                        <div class="dropdown-group-label">Kelas: {{ $namaKelas }}</div>
                                        @foreach($listSantri as $s)
                                            <div class="dropdown-item santri-option" 
                                                 data-id="{{ $s->id }}" 
                                                 data-text="{{ $s->nis }} - {{ $s->nama_santri }}"
                                                 data-search="{{ strtolower($s->nis . ' ' . $s->nama_santri . ' ' . $namaKelas) }}"
                                                 onclick="selectSantri('{{ $s->id }}', '{{ $s->nis }} - {{ $s->nama_santri }}')">
                                                 <strong style="color: #059669;">{{ $s->nis }}</strong> - {{ $s->nama_santri }}
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            
                            <input type="hidden" name="tb_santri_id" id="tb_santri_id" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tipe Kegiatan</label>
                        <div class="radio-toggle">
                            <input type="radio" name="tipe" id="tipe_sorogan" value="sorogan" checked onchange="toggleTipeFields()">
                            <label for="tipe_sorogan">📖 Sorogan</label>
                            
                            <input type="radio" name="tipe" id="tipe_hafalan" value="hafalan" onchange="toggleTipeFields()">
                            <label for="tipe_hafalan">🧠 Hafalan</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Pertemuan</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- TIPE: SOROGAN FIELDS -->
                    <div id="soroganFields">
                        <div class="form-group">
                            <label for="materi">Jenis Materi</label>
                            <select name="materi" id="materi" onchange="toggleMateriFields(); fetchLastProgress();">
                                <option value="iqro">Iqro (Jilid 1-6)</option>
                                <option value="alquran">Al-Quran</option>
                                <option value="juz_amma">Juz Amma (Juz 30)</option>
                            </select>
                        </div>

                        <!-- Sorogan: Iqro -->
                        <div id="materiIqro" class="materi-group">
                            <div class="form-group">
                                <label for="iqro_jilid">Jilid Iqro</label>
                                <select name="iqro_jilid" id="iqro_jilid">
                                    <option value="1">Jilid 1</option>
                                    <option value="2">Jilid 2</option>
                                    <option value="3">Jilid 3</option>
                                    <option value="4">Jilid 4</option>
                                    <option value="5">Jilid 5</option>
                                    <option value="6">Jilid 6</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="iqro_halaman">Halaman</label>
                                <input type="number" name="iqro_halaman" id="iqro_halaman" min="1" placeholder="Masukkan nomor halaman">
                            </div>
                        </div>

                        <!-- Sorogan: Alquran -->
                        <div id="materiAlquran" class="materi-group" style="display: none;">
                            <div class="form-group">
                                <label for="alquran_surah">Surah Al-Quran</label>
                                <select name="alquran_surah" id="alquran_surah">
                                    @foreach($surahs as $num => $name)
                                        <option value="{{ $name }}">{{ $num }}. {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alquran_ayat">Ayat</label>
                                <input type="text" name="alquran_ayat" id="alquran_ayat" placeholder="Contoh: 1, 1-5, atau 10">
                            </div>
                        </div>

                        <!-- Sorogan: Juz Amma -->
                        <div id="materiJuzAmma" class="materi-group" style="display: none;">
                            <div class="form-group">
                                <label for="juz_amma_surah">Surah Juz 30</label>
                                <select name="juz_amma_surah" id="juz_amma_surah">
                                    @foreach($juz30Surahs as $num => $name)
                                        <option value="{{ $name }}">{{ $num }}. {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="juz_amma_ayat">Ayat</label>
                                <input type="text" name="juz_amma_ayat" id="juz_amma_ayat" placeholder="Contoh: 1, 1-5, atau 10">
                            </div>
                        </div>
                    </div>

                    <!-- TIPE: HAFALAN FIELDS -->
                    <div id="hafalanFields" style="display: none;">
                        <div class="form-group">
                            <label for="tb_tpq_master_hafalan_id">Pilih Item Hafalan</label>
                            <select name="tb_tpq_master_hafalan_id" id="tb_tpq_master_hafalan_id" onchange="fetchLastProgress()">
                                <option value="">-- Pilih Materi Hafalan --</option>
                                <optgroup label="Surah Pendek">
                                    @foreach($masterHafalan->where('kategori', 'surah_pendek') as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Doa Sehari-hari">
                                    @foreach($masterHafalan->where('kategori', 'doa_harian') as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan Hasil</label>
                        <div class="radio-toggle">
                            <input type="radio" name="keterangan" id="ket_lanjut" value="lanjut" checked>
                            <label for="ket_lanjut">✅ Lanjut</label>
                            
                            <input type="radio" name="keterangan" id="ket_ulang" value="ulang">
                            <label for="ket_ulang">🔄 Ulang</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3" placeholder="Contoh: Makhraj kurang pas, lancar, dll."></textarea>
                    </div>

                    <button type="submit" class="button-primary">
                        <span>💾</span> Simpan & Kirim WhatsApp
                    </button>
                </form>
            </div>

            <!-- Right Column: Riwayat Input Terbaru -->
            <div class="section">
                <h2>Riwayat Pencatatan Terbaru (Maks. 50)</h2>
                
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Tanggal</th>
                                <th>Nama Santri</th>
                                <th>Kegiatan</th>
                                <th>Detail Materi / Progress</th>
                                <th>Hasil</th>
                                <th>Catatan</th>
                                <th>Petugas</th>
                                <th style="width: 80px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td><strong>{{ $item->santri->nama_santri }}</strong></td>
                                    <td>
                                        @if($item->tipe === 'sorogan')
                                            <span class="badge badge-sorogan">Sorogan</span>
                                        @else
                                            <span class="badge badge-hafalan">Hafalan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->tipe === 'sorogan')
                                            @if($item->materi === 'iqro')
                                                Iqro Jilid {{ $item->iqro_jilid }} Hal. {{ $item->iqro_halaman }}
                                            @elseif($item->materi === 'alquran')
                                                Al-Quran: Surah {{ $item->alquran_surah }} Ayat {{ $item->alquran_ayat }}
                                            @else
                                                Juz Amma: Surah {{ $item->juz_amma_surah }} Ayat {{ $item->juz_amma_ayat }}
                                            @endif
                                        @else
                                            {{ $item->masterHafalan?->nama ?? '-' }} 
                                            <span style="font-size: 11px; color: #6b7280;">({{ $item->masterHafalan?->kategori === 'surah_pendek' ? 'Surah' : 'Doa' }})</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->keterangan === 'lanjut')
                                            <span class="badge badge-lanjut">Lanjut</span>
                                        @else
                                            <span class="badge badge-ulang">Ulang</span>
                                        @endif
                                    </td>
                                    <td class="wrap-column">{{ $item->catatan ?? '-' }}</td>
                                    <td>{{ $item->guru?->nama_guru ?? ($item->user?->name ?? 'Admin') }}</td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('tpq.prestasi.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan prestasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; color:#6b7280; padding:20px;">Belum ada riwayat pencatatan prestasi hari ini.</td>
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

        // Tipe fields toggle
        function toggleTipeFields() {
            const isSorogan = document.getElementById('tipe_sorogan').checked;
            const soroganFields = document.getElementById('soroganFields');
            const hafalanFields = document.getElementById('hafalanFields');

            if (isSorogan) {
                soroganFields.style.display = 'block';
                hafalanFields.style.display = 'none';
            } else {
                soroganFields.style.display = 'none';
                hafalanFields.style.display = 'block';
            }
            fetchLastProgress();
        }

        // Materi fields toggle (Iqro/Al-Quran/Juz Amma)
        function toggleMateriFields() {
            const materiVal = document.getElementById('materi').value;
            document.querySelectorAll('.materi-group').forEach(el => el.style.display = 'none');

            if (materiVal === 'iqro') {
                document.getElementById('materiIqro').style.display = 'block';
            } else if (materiVal === 'alquran') {
                document.getElementById('materiAlquran').style.display = 'block';
            } else if (materiVal === 'juz_amma') {
                document.getElementById('materiJuzAmma').style.display = 'block';
            }
        }

        // AJAX Recommendation fetch
        function fetchLastProgress() {
            const santriId = document.getElementById('tb_santri_id').value;
            const isSorogan = document.getElementById('tipe_sorogan').checked;
            const tipe = isSorogan ? 'sorogan' : 'hafalan';
            const materi = document.getElementById('materi').value;

            const recommendAlert = document.getElementById('recommendationAlert');
            const recommendText = document.getElementById('recommendationText');

            if (!santriId) {
                recommendAlert.style.display = 'none';
                return;
            }

            // For Hafalan, only fetch if master item is selected
            const masterHafalanId = document.getElementById('tb_tpq_master_hafalan_id').value;
            if (!isSorogan && !masterHafalanId) {
                recommendAlert.style.display = 'none';
                return;
            }

            let url = `{{ route('tpq.prestasi.last-progress') }}?santri_id=${santriId}&tipe=${tipe}`;
            if (isSorogan) {
                url += `&materi=${materi}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(res => {
                    if (res.success && res.data && res.data.recommendation) {
                        const rec = res.data.recommendation;
                        const lastRec = res.data.last_record;
                        const statusLabel = lastRec.keterangan === 'lanjut' ? 'Lanjut' : 'Ulang';

                        if (isSorogan) {
                            if (materi === 'iqro') {
                                document.getElementById('iqro_jilid').value = rec.iqro_jilid;
                                document.getElementById('iqro_halaman').value = rec.iqro_halaman;
                                recommendText.textContent = `Pertemuan sebelumnya: Jilid ${lastRec.iqro_jilid} Hal. ${lastRec.iqro_halaman} (${statusLabel}). Halaman otomatis terisi ke rekomendasi baru.`;
                            } else if (materi === 'alquran') {
                                document.getElementById('alquran_surah').value = rec.alquran_surah;
                                document.getElementById('alquran_ayat').value = rec.alquran_ayat;
                                recommendText.textContent = `Pertemuan sebelumnya: Surah ${lastRec.alquran_surah} Ayat ${lastRec.alquran_ayat} (${statusLabel}). Ayat otomatis terisi ke rekomendasi baru.`;
                            } else if (materi === 'juz_amma') {
                                document.getElementById('juz_amma_surah').value = rec.juz_amma_surah;
                                document.getElementById('juz_amma_ayat').value = rec.juz_amma_ayat;
                                recommendText.textContent = `Pertemuan sebelumnya: Surah ${lastRec.juz_amma_surah} Ayat ${lastRec.juz_amma_ayat} (${statusLabel}). Ayat otomatis terisi ke rekomendasi baru.`;
                            }
                        } else {
                            if (rec.tb_tpq_master_hafalan_id) {
                                document.getElementById('tb_tpq_master_hafalan_id').value = rec.tb_tpq_master_hafalan_id;
                                const optionText = document.querySelector(`#tb_tpq_master_hafalan_id option[value="${rec.tb_tpq_master_hafalan_id}"]`).textContent;
                                recommendText.textContent = `Hasil sebelumnya: ${statusLabel}. Direkomendasikan untuk beralih ke: ${optionText}`;
                            }
                        }
                        recommendAlert.style.display = 'flex';
                    } else {
                        recommendAlert.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error(err);
                    recommendAlert.style.display = 'none';
                });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const container = document.getElementById('santriSelectContainer');
            const dropdownList = document.getElementById('santriDropdownList');
            if (container && !container.contains(event.target)) {
                dropdownList.style.display = 'none';
            }
        });

        function toggleSantriDropdown(event) {
            event.stopPropagation();
            const dropdownList = document.getElementById('santriDropdownList');
            const isOpen = dropdownList.style.display === 'block';
            
            // Close or open
            dropdownList.style.display = isOpen ? 'none' : 'block';
            
            if (!isOpen) {
                // Focus the search box inside dropdown
                const searchInput = document.getElementById('santriSearchInput');
                searchInput.value = '';
                searchInput.focus();
                
                // Reset option visibility
                filterSantriDropdown();
            }
        }

        function filterSantriDropdown() {
            const searchInput = document.getElementById('santriSearchInput');
            const filter = searchInput.value.toLowerCase().trim();
            const items = document.querySelectorAll('.santri-option');
            const groupLabels = document.querySelectorAll('.dropdown-group-label');

            items.forEach(item => {
                const searchText = item.getAttribute('data-search');
                if (searchText.indexOf(filter) > -1) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });

            groupLabels.forEach(label => {
                let sibling = label.nextElementSibling;
                let hasVisible = false;
                while (sibling && !sibling.classList.contains('dropdown-group-label')) {
                    if (sibling.classList.contains('santri-option') && sibling.style.display !== 'none') {
                        hasVisible = true;
                        break;
                    }
                    sibling = sibling.nextElementSibling;
                }
                label.style.display = hasVisible ? 'block' : 'none';
            });
        }

        function selectSantri(id, text) {
            const hiddenInput = document.getElementById('tb_santri_id');
            const trigger = document.getElementById('santriSelectTrigger');
            const dropdownList = document.getElementById('santriDropdownList');

            hiddenInput.value = id;
            trigger.textContent = text;
            dropdownList.style.display = 'none';

            if (id === '') {
                document.getElementById('recommendationAlert').style.display = 'none';
            }

            // Manually trigger fetchLastProgress
            fetchLastProgress();
        }
    </script>
</body>
</html>
