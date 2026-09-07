<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo e($logoFavicon); ?>">
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

        /* ── Pagination Buttons ── */
        .pagination-btn { display: inline-flex; align-items: center; justify-content: center; padding: 6px 12px; border-radius: 8px; border: 1px solid #d1e7dd; background: #ffffff; color: #10714f; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .pagination-btn:hover { background: #f0fcf5; border-color: #a7f3d0; }
        .pagination-btn.active { background: #10b981; color: white; border-color: #10b981; pointer-events: none; }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; background: #ffffff; border-color: #e6f4ed; color: #9ca3af; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>📚</span> Manajemen TPQ
        </div>
        <nav class="sidebar-nav">
            <a href="<?php echo e(route('tpq.dashboard')); ?>">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            <?php if(auth()->user()->hasAccess('tpq.guru')): ?>
            <a href="<?php echo e(route('tpq.guru.index')); ?>">
                <span class="nav-icon">👨‍🏫</span> Data Guru
            </a>
            <?php endif; ?>
            <?php if(auth()->user()->hasAccess('tpq.kelas')): ?>
            <a href="<?php echo e(route('tpq.kelas.index')); ?>">
                <span class="nav-icon">🏫</span> Data Kelas
            </a>
            <?php endif; ?>
            <?php if(auth()->user()->hasAccess('tpq.santri')): ?>
            <a href="<?php echo e(route('tpq.santri.index')); ?>">
                <span class="nav-icon">🧑‍🎓</span> Data Santri
            </a>
            <?php endif; ?>
            <?php if(auth()->user()->hasAccess('tpq.absensi')): ?>
            <a href="<?php echo e(route('tpq.absensi.index')); ?>">
                <span class="nav-icon">📝</span> Absensi Santri
            </a>
            <?php endif; ?>
            <?php if(auth()->user()->hasAccess('tpq.laporan')): ?>
            <a href="<?php echo e(route('tpq.laporan.index')); ?>">
                <span class="nav-icon">📊</span> Laporan Absen
            </a>
            <?php endif; ?>
            <a href="<?php echo e(route('tpq.prestasi.index')); ?>" class="active">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            <?php if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator'): ?>
            <a href="<?php echo e(route('tpq.master-hafalan.index')); ?>">
                <span class="nav-icon">⚙️</span> Master Hafalan
            </a>
            <?php endif; ?>
            <div class="divider"></div>
            <a href="<?php echo e(route('dashboard')); ?>">
                <span class="nav-icon">⬅️</span> Dashboard Utama
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul style="margin-left: 16px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid">
            <!-- Left Column: Form Input Prestasi -->
            <div class="section">
                <h2>Catat Prestasi Baru</h2>

                <div id="recommendationAlert" class="recommend-alert">
                    <span>💡</span> <span id="recommendationText">Rekomendasi halaman otomatis terisi.</span>
                </div>

                <form action="<?php echo e(route('tpq.prestasi.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

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
                                    
                                    <?php $__currentLoopData = $santris->groupBy(fn($s) => $s->kelas?->nama_kelas ?? 'Tanpa Kelas'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namaKelas => $listSantri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="dropdown-group-label">Kelas: <?php echo e($namaKelas); ?></div>
                                        <?php $__currentLoopData = $listSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="dropdown-item santri-option" 
                                                 data-id="<?php echo e($s->id); ?>" 
                                                 data-text="<?php echo e($s->nis); ?> - <?php echo e($s->nama_santri); ?>"
                                                 data-search="<?php echo e(strtolower($s->nis . ' ' . $s->nama_santri . ' ' . $namaKelas)); ?>"
                                                 onclick="selectSantri('<?php echo e($s->id); ?>', '<?php echo e($s->nis); ?> - <?php echo e($s->nama_santri); ?>')">
                                                 <strong style="color: #059669;"><?php echo e($s->nis); ?></strong> - <?php echo e($s->nama_santri); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <input type="date" name="tanggal" id="tanggal" value="<?php echo e(date('Y-m-d')); ?>" required>
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
                                <label>Surah Al-Quran</label>
                                <div class="custom-select-container" id="surahSelectContainer">
                                    <div id="surahSelectTrigger" class="custom-select-trigger" onclick="toggleSurahDropdown(event)">
                                        <?php if(count($surahs) > 0): ?>
                                            <?php
                                                $firstNum = array_key_first($surahs);
                                                $firstName = $surahs[$firstNum];
                                            ?>
                                            <?php echo e($firstNum); ?>. <?php echo e($firstName); ?>

                                        <?php else: ?>
                                            -- Pilih Surah --
                                        <?php endif; ?>
                                    </div>
                                    <div id="surahDropdownList" class="custom-dropdown-list">
                                        <div class="dropdown-search-wrapper">
                                            <input type="text" id="surahSearchInput" placeholder="Cari surah..." autocomplete="off" oninput="filterSurahDropdown()">
                                        </div>
                                        <div class="dropdown-options-wrapper">
                                            <?php $__currentLoopData = $surahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="dropdown-item surah-option" 
                                                     data-value="<?php echo e($name); ?>" 
                                                     data-text="<?php echo e($num); ?>. <?php echo e($name); ?>"
                                                     data-search="<?php echo e(strtolower($num . ' ' . $name)); ?>"
                                                     onclick="selectSurah('<?php echo e($name); ?>', '<?php echo e($num); ?>. <?php echo e($name); ?>')">
                                                     <strong><?php echo e($num); ?>.</strong> <?php echo e($name); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <input type="hidden" name="alquran_surah" id="alquran_surah" value="<?php echo e(count($surahs) > 0 ? $surahs[array_key_first($surahs)] : ''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alquran_ayat">Ayat</label>
                                <input type="text" name="alquran_ayat" id="alquran_ayat" placeholder="Contoh: 1, 1-5, atau 10">
                            </div>
                        </div>

                        <!-- Sorogan: Juz Amma -->
                        <div id="materiJuzAmma" class="materi-group" style="display: none;">
                            <div class="form-group">
                                <label>Surah Juz 30</label>
                                <div class="custom-select-container" id="juzAmmaSelectContainer">
                                    <div id="juzAmmaSelectTrigger" class="custom-select-trigger" onclick="toggleJuzAmmaDropdown(event)">
                                        <?php if(count($juz30Surahs) > 0): ?>
                                            <?php
                                                $firstNum = array_key_first($juz30Surahs);
                                                $firstName = $juz30Surahs[$firstNum];
                                            ?>
                                            <?php echo e($firstNum); ?>. <?php echo e($firstName); ?>

                                        <?php else: ?>
                                            -- Pilih Surah --
                                        <?php endif; ?>
                                    </div>
                                    <div id="juzAmmaDropdownList" class="custom-dropdown-list">
                                        <div class="dropdown-search-wrapper">
                                            <input type="text" id="juzAmmaSearchInput" placeholder="Cari surah..." autocomplete="off" oninput="filterJuzAmmaDropdown()">
                                        </div>
                                        <div class="dropdown-options-wrapper">
                                            <?php $__currentLoopData = $juz30Surahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="dropdown-item juz-amma-option" 
                                                     data-value="<?php echo e($name); ?>" 
                                                     data-text="<?php echo e($num); ?>. <?php echo e($name); ?>"
                                                     data-search="<?php echo e(strtolower($num . ' ' . $name)); ?>"
                                                     onclick="selectJuzAmma('<?php echo e($name); ?>', '<?php echo e($num); ?>. <?php echo e($name); ?>')">
                                                     <strong><?php echo e($num); ?>.</strong> <?php echo e($name); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <input type="hidden" name="juz_amma_surah" id="juz_amma_surah" value="<?php echo e(count($juz30Surahs) > 0 ? $juz30Surahs[array_key_first($juz30Surahs)] : ''); ?>">
                                </div>
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
                                    <?php $__currentLoopData = $masterHafalan->where('kategori', 'surah_pendek'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                                <optgroup label="Doa Sehari-hari">
                                    <?php $__currentLoopData = $masterHafalan->where('kategori', 'doa_harian'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px;">
                    <h2 style="margin-bottom: 0;">Riwayat Pencatatan Terbaru (Maks. 50)</h2>
                    <input type="text" id="tableSearchInput" placeholder="Cari riwayat..." style="padding: 10px 14px; border-radius: 10px; border: 1px solid #d1e7dd; font-size: 13.5px; background: #fbfffe; color: #103a2d; min-width: 200px; outline: none; transition: border-color 0.2s;">
                </div>
                
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
                            <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($item->tanggal->format('d/m/Y')); ?></td>
                                    <td><strong><?php echo e($item->santri->nama_santri); ?></strong></td>
                                    <td>
                                        <?php if($item->tipe === 'sorogan'): ?>
                                            <span class="badge badge-sorogan">Sorogan</span>
                                        <?php else: ?>
                                            <span class="badge badge-hafalan">Hafalan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($item->tipe === 'sorogan'): ?>
                                            <?php if($item->materi === 'iqro'): ?>
                                                Iqro Jilid <?php echo e($item->iqro_jilid); ?> Hal. <?php echo e($item->iqro_halaman); ?>

                                            <?php elseif($item->materi === 'alquran'): ?>
                                                Al-Quran: Surah <?php echo e($item->alquran_surah); ?> Ayat <?php echo e($item->alquran_ayat); ?>

                                            <?php else: ?>
                                                Juz Amma: Surah <?php echo e($item->juz_amma_surah); ?> Ayat <?php echo e($item->juz_amma_ayat); ?>

                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo e($item->masterHafalan?->nama ?? '-'); ?> 
                                            <span style="font-size: 11px; color: #6b7280;">(<?php echo e($item->masterHafalan?->kategori === 'surah_pendek' ? 'Surah' : 'Doa'); ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($item->keterangan === 'lanjut'): ?>
                                            <span class="badge badge-lanjut">Lanjut</span>
                                        <?php else: ?>
                                            <span class="badge badge-ulang">Ulang</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="wrap-column"><?php echo e($item->catatan ?? '-'); ?></td>
                                    <td><?php echo e($item->guru?->nama_guru ?? ($item->user?->name ?? 'Admin')); ?></td>
                                    <td style="text-align: center;">
                                        <form action="<?php echo e(route('tpq.prestasi.destroy', $item->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan prestasi ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr class="no-data-row">
                                    <td colspan="9" style="text-align: center; color:#6b7280; padding:20px;">Belum ada riwayat pencatatan prestasi hari ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Controls -->
                <div id="pagination-controls" style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 12px; border-top: 1px solid #e6f4ed; flex-wrap: wrap; gap: 10px;">
                    <div id="pagination-info" style="font-size: 13px; color: #5c7b73;">
                        Menampilkan <span id="start-row">0</span> - <span id="end-row">0</span> dari <span id="total-rows">0</span> catatan
                    </div>
                    <div style="display: flex; gap: 6px;" id="pagination-buttons"></div>
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

            let url = `<?php echo e(route('tpq.prestasi.last-progress')); ?>?santri_id=${santriId}&tipe=${tipe}`;
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
                                updateSurahTrigger(rec.alquran_surah);
                                document.getElementById('alquran_ayat').value = rec.alquran_ayat;
                                recommendText.textContent = `Pertemuan sebelumnya: Surah ${lastRec.alquran_surah} Ayat ${lastRec.alquran_ayat} (${statusLabel}). Ayat otomatis terisi ke rekomendasi baru.`;
                            } else if (materi === 'juz_amma') {
                                document.getElementById('juz_amma_surah').value = rec.juz_amma_surah;
                                updateJuzAmmaTrigger(rec.juz_amma_surah);
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

            const surahContainer = document.getElementById('surahSelectContainer');
            const surahDropdownList = document.getElementById('surahDropdownList');
            if (surahContainer && !surahContainer.contains(event.target)) {
                surahDropdownList.style.display = 'none';
            }

            const juzAmmaContainer = document.getElementById('juzAmmaSelectContainer');
            const juzAmmaDropdownList = document.getElementById('juzAmmaDropdownList');
            if (juzAmmaContainer && !juzAmmaContainer.contains(event.target)) {
                juzAmmaDropdownList.style.display = 'none';
            }
        });

        // Santri Dropdown Logic
        function toggleSantriDropdown(event) {
            event.stopPropagation();
            const dropdownList = document.getElementById('santriDropdownList');
            const isOpen = dropdownList.style.display === 'block';
            
            // Close other dropdowns
            const surahList = document.getElementById('surahDropdownList');
            if (surahList) surahList.style.display = 'none';
            const juzAmmaList = document.getElementById('juzAmmaDropdownList');
            if (juzAmmaList) juzAmmaList.style.display = 'none';

            dropdownList.style.display = isOpen ? 'none' : 'block';
            
            if (!isOpen) {
                const searchInput = document.getElementById('santriSearchInput');
                searchInput.value = '';
                searchInput.focus();
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

            fetchLastProgress();
        }

        // Surah Al-Quran Dropdown Logic
        function toggleSurahDropdown(event) {
            event.stopPropagation();
            const dropdownList = document.getElementById('surahDropdownList');
            const isOpen = dropdownList.style.display === 'block';
            
            // Close other dropdowns
            document.getElementById('santriDropdownList').style.display = 'none';
            const juzAmmaList = document.getElementById('juzAmmaDropdownList');
            if (juzAmmaList) juzAmmaList.style.display = 'none';

            dropdownList.style.display = isOpen ? 'none' : 'block';
            
            if (!isOpen) {
                const searchInput = document.getElementById('surahSearchInput');
                searchInput.value = '';
                searchInput.focus();
                filterSurahDropdown();
            }
        }

        function filterSurahDropdown() {
            const searchInput = document.getElementById('surahSearchInput');
            const filter = searchInput.value.toLowerCase().trim();
            const items = document.querySelectorAll('.surah-option');

            items.forEach(item => {
                const searchText = item.getAttribute('data-search');
                if (searchText.indexOf(filter) > -1) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function selectSurah(val, text) {
            const trigger = document.getElementById('surahSelectTrigger');
            const hiddenInput = document.getElementById('alquran_surah');
            const dropdownList = document.getElementById('surahDropdownList');
            
            hiddenInput.value = val;
            trigger.textContent = text;
            dropdownList.style.display = 'none';
            
            fetchLastProgress();
        }

        function updateSurahTrigger(val) {
            const trigger = document.getElementById('surahSelectTrigger');
            if (!trigger) return;
            const options = document.querySelectorAll('.surah-option');
            let foundText = val;
            options.forEach(opt => {
                if (opt.getAttribute('data-value') === val) {
                    foundText = opt.getAttribute('data-text');
                }
            });
            trigger.textContent = foundText;
        }

        // Juz Amma Dropdown Logic
        function toggleJuzAmmaDropdown(event) {
            event.stopPropagation();
            const dropdownList = document.getElementById('juzAmmaDropdownList');
            const isOpen = dropdownList.style.display === 'block';
            
            // Close other dropdowns
            document.getElementById('santriDropdownList').style.display = 'none';
            const surahList = document.getElementById('surahDropdownList');
            if (surahList) surahList.style.display = 'none';

            dropdownList.style.display = isOpen ? 'none' : 'block';
            
            if (!isOpen) {
                const searchInput = document.getElementById('juzAmmaSearchInput');
                searchInput.value = '';
                searchInput.focus();
                filterJuzAmmaDropdown();
            }
        }

        function filterJuzAmmaDropdown() {
            const searchInput = document.getElementById('juzAmmaSearchInput');
            const filter = searchInput.value.toLowerCase().trim();
            const items = document.querySelectorAll('.juz-amma-option');

            items.forEach(item => {
                const searchText = item.getAttribute('data-search');
                if (searchText.indexOf(filter) > -1) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Select Juz Amma Surah
        function selectJuzAmma(val, text) {
            const trigger = document.getElementById('juzAmmaSelectTrigger');
            const hiddenInput = document.getElementById('juz_amma_surah');
            const dropdownList = document.getElementById('juzAmmaDropdownList');
            
            hiddenInput.value = val;
            trigger.textContent = text;
            dropdownList.style.display = 'none';
            
            fetchLastProgress();
        }

        // Update Juz Amma Trigger
        function updateJuzAmmaTrigger(val) {
            const trigger = document.getElementById('juzAmmaSelectTrigger');
            if (!trigger) return;
            const options = document.querySelectorAll('.juz-amma-option');
            let foundText = val;
            options.forEach(opt => {
                if (opt.getAttribute('data-value') === val) {
                    foundText = opt.getAttribute('data-text');
                }
            });
            trigger.textContent = foundText;
        }

        // Client-side search and pagination logic for table
        const tableSearchInput = document.getElementById('tableSearchInput');
        const tableBody = document.querySelector('table tbody');
        const allRows = Array.from(tableBody.querySelectorAll('tr:not(.no-data-row)'));
        
        let filteredRows = [...allRows];
        const rowsPerPage = 10;
        let currentPage = 1;

        function updateTable() {
            const query = tableSearchInput.value.toLowerCase().trim();
            
            // 1. Filter rows based on search
            filteredRows = allRows.filter(row => {
                const cells = Array.from(row.querySelectorAll('td'));
                const searchString = cells.map(td => td.textContent.toLowerCase()).join(' ');
                return searchString.includes(query);
            });

            // Handle "No data" message row
            let noDataRow = tableBody.querySelector('.no-match-row');
            if (filteredRows.length === 0) {
                if (!noDataRow) {
                    noDataRow = document.createElement('tr');
                    noDataRow.className = 'no-match-row';
                    noDataRow.innerHTML = '<td colspan="9" style="text-align:center; color:#9ca3af; padding: 20px 0;">Tidak ada catatan prestasi yang cocok.</td>';
                    tableBody.appendChild(noDataRow);
                } else {
                    noDataRow.style.display = '';
                }
                const originalNoDataRow = tableBody.querySelector('.no-data-row');
                if (originalNoDataRow) originalNoDataRow.style.display = 'none';
            } else {
                if (noDataRow) {
                    noDataRow.style.display = 'none';
                }
            }

            // 2. Paginate filtered rows
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

            // Hide all data rows first
            allRows.forEach(row => row.style.display = 'none');

            // Show matching rows for current page
            for (let i = startIndex; i < endIndex; i++) {
                filteredRows[i].style.display = '';
                filteredRows[i].firstElementChild.textContent = i + 1;
            }

            // 3. Update pagination controls
            document.getElementById('start-row').textContent = totalRows > 0 ? startIndex + 1 : 0;
            document.getElementById('end-row').textContent = endIndex;
            document.getElementById('total-rows').textContent = totalRows;

            const buttonsContainer = document.getElementById('pagination-buttons');
            buttonsContainer.innerHTML = '';

            if (totalPages > 1) {
                // Prev button
                const prevBtn = document.createElement('button');
                prevBtn.className = 'pagination-btn';
                prevBtn.textContent = 'Sebelumnya';
                prevBtn.disabled = currentPage === 1;
                prevBtn.onclick = () => {
                    currentPage--;
                    updateTable();
                };
                buttonsContainer.appendChild(prevBtn);

                // Page numbers
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                for (let p = startPage; p <= endPage; p++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = 'pagination-btn' + (p === currentPage ? ' active' : '');
                    pageBtn.textContent = p;
                    pageBtn.onclick = () => {
                        currentPage = p;
                        updateTable();
                    };
                    buttonsContainer.appendChild(pageBtn);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.className = 'pagination-btn';
                nextBtn.textContent = 'Berikutnya';
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.onclick = () => {
                    currentPage++;
                    updateTable();
                };
                buttonsContainer.appendChild(nextBtn);
            }
        }

        // Attach event listener
        tableSearchInput.addEventListener('input', () => {
            currentPage = 1;
            updateTable();
        });

        // Initialize table
        updateTable();
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\masjid-baginda\resources\views/tpq/prestasi.blade.php ENDPATH**/ ?>