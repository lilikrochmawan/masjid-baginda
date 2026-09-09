<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo e($logoFavicon); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koin Baginda - Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3faf7; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; height: 100vh; background: linear-gradient(180deg, #059669 0%, #047857 100%); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 200; transition: transform 0.3s ease; overflow-y: auto; }
        .sidebar-brand { padding: 22px 20px 18px; font-size: 18px; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .sidebar-brand span { font-size: 22px; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .sidebar-nav a, .sidebar-nav button { display: flex; align-items: center; gap: 10px; width: 100%; padding: 11px 20px; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 13.5px; font-weight: 500; border: none; background: none; cursor: pointer; transition: background 0.2s, color 0.2s; text-align: left; }
        .sidebar-nav a:hover, .sidebar-nav button:hover { background: rgba(255,255,255,0.12); color: white; }
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
        .page-title h1 { font-size: 26px; color: #0f4d36; font-weight: 700; }

        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: white; padding: 18px 14px; border-radius: 12px; box-shadow: 0 4px 16px rgba(15,60,40,0.07); text-align: center; }
        .stat-card h2 { color: #6b7280; font-size: 11px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .5px; }
        .stat-value { font-size: 30px; font-weight: 700; color: #047857; }

        .module-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .module-card { background: white; padding: 20px 16px; border-radius: 12px; border: 1px solid #d9f7e2; text-align: center; box-shadow: 0 4px 16px rgba(15,60,40,0.05); transition: transform 0.2s, box-shadow 0.2s; }
        .module-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(15,60,40,0.1); }
        .module-card h3 { margin-top: 12px; color: #0f4d36; font-size: 14px; font-weight: 600; }
        .module-link { display: inline-flex; align-items: center; justify-content: center; width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 24px; margin: 0 auto; }
        .module-card p { color: #6b7280; margin-top: 8px; line-height: 1.5; font-size: 12px; }
        .module-button { display: inline-block; margin-top: 12px; padding: 7px 16px; border-radius: 8px; background: #10b981; color: white; text-decoration: none; font-weight: 600; font-size: 12px; transition: opacity 0.2s; }
        .module-button:hover { opacity: 0.85; }

        @media (max-width: 900px) {
            .module-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .module-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .module-card { padding: 16px 12px; }
            .module-link { width: 48px; height: 48px; font-size: 20px; }
        }
        @media (max-width: 400px) {
            .module-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>🥫</span> Koin Baginda
        </div>
        <nav class="sidebar-nav">
            <a href="<?php echo e(route('koin.index')); ?>" class="active">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            <?php if(auth()->user()->hasAccess('koin.inventory')): ?>
<a href="<?php echo e(route('koin.inventory')); ?>">
                <span class="nav-icon">📦</span> Inventori
            </a>
<?php endif; ?>
            <?php if(auth()->user()->hasAccess('koin.pemilik')): ?>
<a href="<?php echo e(route('koin.pemilik')); ?>">
                <span class="nav-icon">👤</span> Pemilik
            </a>
<?php endif; ?>
            <?php if(auth()->user()->hasAccess('koin.scan')): ?>
<a href="<?php echo e(route('koin.scan')); ?>">
                <span class="nav-icon">📷</span> Scan
            </a>
<?php endif; ?>
            <?php if(auth()->user()->hasAccess('koin.qr.generate')): ?>
<a href="<?php echo e(route('koin.qr.generate')); ?>">
                <span class="nav-icon">🖼️</span> Generate QR
            </a>
<?php endif; ?>
            <?php if(auth()->user()->hasAccess('koin.penerimaan')): ?>
<a href="<?php echo e(route('koin.penerimaan.create')); ?>">
                <span class="nav-icon">🧾</span> Penerimaan
            </a>
<?php endif; ?>
            <?php if(auth()->user()->hasAccess('koin.laporan')): ?>
<a href="<?php echo e(route('koin.laporan')); ?>">
                <span class="nav-icon">📊</span> Laporan
            </a>
<?php endif; ?>
            <div class="divider"></div>
            <a href="<?php echo e(route('dashboard')); ?>">
                <span class="nav-icon">⬅️</span> Dashboard
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Topbar (mobile only) -->
    <div class="topbar">
        <span class="topbar-brand">Koin Baginda</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Modul Koin Baginda</h1></div>

        <div class="stats">
            <div class="stat-card"><h2>Total Kaleng</h2><div class="stat-value"><?php echo e($stats['kaleng']); ?></div></div>
            <div class="stat-card"><h2>Total Pemilik</h2><div class="stat-value"><?php echo e($stats['pemilik']); ?></div></div>
            <div class="stat-card"><h2>Total Transaksi</h2><div class="stat-value"><?php echo e($stats['transaksi']); ?></div></div>
        </div>

        <div class="module-grid">
            <div class="module-card">
                <div class="module-link">🥫</div>
                <h3>Inventori Kaleng</h3>
                <p>Kelola data kaleng</p>
                <?php if(auth()->user()->hasAccess('koin.inventory')): ?>
<a class="module-button" href="<?php echo e(route('koin.inventory')); ?>">Buka</a>
<?php endif; ?>
            </div>
            <div class="module-card">
                <div class="module-link">👤</div>
                <h3>Pemilik Kaleng</h3>
                <p>Input data pemilik, alamat, dan tanggal penyerahan.</p>
                <?php if(auth()->user()->hasAccess('koin.pemilik')): ?>
<a class="module-button" href="<?php echo e(route('koin.pemilik')); ?>">Buka</a>
<?php endif; ?>
            </div>
            <div class="module-card">
                <div class="module-link">📷</div>
                <h3>Transaksi Scan</h3>
                <p>Scan pengambilan kaleng bulanan</p>
                <?php if(auth()->user()->hasAccess('koin.scan')): ?>
<a class="module-button" href="<?php echo e(route('koin.scan')); ?>">Scan</a>
<?php endif; ?>
            </div>
            <div class="module-card">
                <div class="module-link">🧾</div>
                <h3>Penerimaan Kaleng</h3>
                <p>Input tanggal dan jumlah penerimaan</p>
                <?php if(auth()->user()->hasAccess('koin.penerimaan')): ?>
<a class="module-button" href="<?php echo e(route('koin.penerimaan.create')); ?>">Input</a>
<?php endif; ?>
            </div>
            <div class="module-card">
                <div class="module-link">�📊</div>
                <h3>Laporan Koin</h3>
                <p>Lihat status scan bulan ini dan penerimaan global</p>
                <?php if(auth()->user()->hasAccess('koin.laporan')): ?>
<a class="module-button" href="<?php echo e(route('koin.laporan')); ?>">Lihat</a>
<?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\masjid-baginda\resources\views/koin/index.blade.php ENDPATH**/ ?>