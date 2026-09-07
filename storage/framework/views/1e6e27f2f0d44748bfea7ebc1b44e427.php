<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo e($logoFavicon); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arus Kas TPQ - Baginda</title>
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

        /* ── Navigation Tabs ── */
        .tabs-nav { display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid #e6f4ed; padding-bottom: 12px; overflow-x: auto; }
        .tab-btn { padding: 10px 18px; text-decoration: none; color: #164a3f; font-size: 13.5px; font-weight: 600; border-radius: 8px; background: #eef7f4; transition: all 0.2s ease; white-space: nowrap; }
        .tab-btn:hover { background: #d1e7dd; color: #0f4d36; }
        .tab-btn.active { background: #10b981; color: white; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; outline: none; }
        .form-group textarea { min-height: 80px; resize: vertical; }

        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }

        .badge-masuk { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }
        .badge-keluar { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700; }

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
            <a href="<?php echo e(route('tpq.prestasi.index')); ?>">
                <span class="nav-icon">📖</span> Kartu Prestasi
            </a>
            <?php if(auth()->user()->hasAccess('tpq.guru') || auth()->user()->hakakses->nama_hakakses === 'administrator'): ?>
            <a href="<?php echo e(route('tpq.master-hafalan.index')); ?>">
                <span class="nav-icon">⚙️</span> Master Hafalan
            </a>
            <?php endif; ?>
            <?php if(auth()->user()->hasAccess('tpq.keuangan')): ?>
            <a href="<?php echo e(route('tpq.keuangan.spp.index')); ?>" class="active">
                <span class="nav-icon">💰</span> Keuangan TPQ
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
        <span class="topbar-brand">Keuangan TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Keuangan TPQ</h1>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs-nav">
            <a href="<?php echo e(route('tpq.keuangan.spp.index')); ?>" class="tab-btn">Pembayaran SPP</a>
            <a href="<?php echo e(route('tpq.keuangan.rekap.index')); ?>" class="tab-btn">Rekap SPP</a>
            <a href="<?php echo e(route('tpq.keuangan.kas.index')); ?>" class="tab-btn active">Arus Kas (Cashflow)</a>
            <a href="<?php echo e(route('tpq.keuangan.laporan.index')); ?>" class="tab-btn">Laporan Kas</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul style="padding-left: 16px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid">
            <!-- Left: Input Form -->
            <div class="section">
                <h2>Catat Transaksi Kas</h2>
                <form action="<?php echo e(route('tpq.keuangan.kas.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Transaksi</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipe">Tipe Transaksi</label>
                        <select id="tipe" name="tipe" required>
                            <option value="">Pilih Tipe</option>
                            <option value="masuk">Kas Masuk (Penerimaan)</option>
                            <option value="keluar">Kas Keluar (Pengeluaran)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Uang (Rp)</label>
                        <input type="number" id="jumlah" name="jumlah" min="1" required placeholder="Masukkan nominal transaksi">
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan / Rincian</label>
                        <textarea id="keterangan" name="keterangan" required placeholder="Masukkan rincian transaksi kas..."></textarea>
                    </div>

                    <button type="submit" class="button-primary">Simpan Transaksi</button>
                </form>
            </div>

            <!-- Right: Log History -->
            <div class="section">
                <h2>Riwayat Transaksi Kas TPQ</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Pencatat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $kasEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e(date('d-m-Y', strtotime($entry->tanggal))); ?></td>
                                    <td>
                                        <strong><?php echo e($entry->keterangan); ?></strong>
                                        <?php if($entry->tb_spp_pembayaran_id): ?>
                                            <div style="font-size:11px; color:#0f766e; margin-top:2px;">
                                                🔗 Terkait SPP Santri
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($entry->tipe === 'masuk'): ?>
                                            <span class="badge-masuk">Masuk</span>
                                        <?php else: ?>
                                            <span class="badge-keluar">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong>Rp <?php echo e(number_format($entry->jumlah, 0, ',', '.')); ?></strong></td>
                                    <td><?php echo e($entry->user->name ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; color:#9ca3af;">Belum ada riwayat transaksi kas.</td>
                                </tr>
                            <?php endif; ?>
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
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\masjid-baginda\resources\views/tpq/keuangan/kas.blade.php ENDPATH**/ ?>