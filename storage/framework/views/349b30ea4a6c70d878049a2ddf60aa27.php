<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo e($logoFavicon); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas TPQ - Baginda</title>
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
        
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; }
        .button-primary:hover { transform: translateY(-1px); }
        .button-secondary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #6b7280; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; font-size: 13.5px; text-decoration: none; margin-left: 8px; }
        .button-secondary:hover { transform: translateY(-1px); }

        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 500px; }
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border-radius: 12px;
            border: 1px solid #d1e7dd;
            min-height: 46px;
            padding: 4px;
            background: #fbfffe;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #10b981;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #10b981;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 4px 8px;
            margin-top: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
            border-right: 1px solid rgba(255,255,255,0.2);
            padding-right: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background: transparent;
            color: #ffcccc;
        }
        
        /* Sembunyikan opsi yang sudah dipilih dari daftar dropdown */
        .select2-results__option[aria-selected="true"] {
            display: none !important;
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
<a href="<?php echo e(route('tpq.kelas.index')); ?>" class="active">
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
            <a href="<?php echo e(route('tpq.keuangan.spp.index')); ?>" class="<?php echo e(request()->routeIs('tpq.keuangan.*') ? 'active' : ''); ?>">
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
        <span class="topbar-brand">Data Kelas TPQ</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title">
            <h1>Manajemen Data Kelas</h1>
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
            <!-- Left Side: Form -->
            <div class="section" id="form-container">
                <h2 id="form-title">Tambah Kelas Baru</h2>
                <form id="kelas-form" action="<?php echo e(route('tpq.kelas.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="method-field" name="_method" value="POST">

                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" required placeholder="Masukkan nama kelas (contoh: Kelas Alif)">
                    </div>

                    <div class="form-group">
                        <label for="tb_guru_id">Guru Pengampu</label>
                        <select id="tb_guru_id" name="tb_guru_id[]" multiple="multiple" style="width: 100%;">
                            <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_guru); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" class="button-primary" id="btn-submit">Simpan Kelas</button>
                    <button type="button" class="button-secondary" id="btn-cancel" style="display:none;" onclick="resetForm()">Batal</button>
                </form>
            </div>

            <!-- Right Side: Table -->
            <div class="section">
                <h2>Daftar Kelas</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kelas</th>
                                <th>Guru Pengampu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><strong><?php echo e($item->nama_kelas); ?></strong></td>
                                    <td>
                                        <?php if($item->gurus->count() > 0): ?>
                                            <span style="color:#0f766e; font-weight:600;">👨‍🏫 <?php echo e($item->gurus->pluck('nama_guru')->join(', ')); ?></span>
                                        <?php else: ?>
                                            <span style="color:#9ca3af; font-style:italic;">Belum ditentukan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn-action" onclick='editKelas(<?php echo json_encode($item, 15, 512) ?>, <?php echo json_encode($item->gurus->pluck("id"), 15, 512) ?>)'>Ubah</button>
                                        <form action="<?php echo e(route('tpq.kelas.destroy', $item->id)); ?>" method="POST" style="display:inline; margin-left: 4px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Santri di kelas ini akan dipindahkan ke tanpa kelas.')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-action btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" style="text-align:center; color:#9ca3af;">Belum ada data kelas.</td>
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

        // Edit Kelas function
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('form-title');
        const form = document.getElementById('kelas-form');
        const methodField = document.getElementById('method-field');
        const submitBtn = document.getElementById('btn-submit');
        const cancelBtn = document.getElementById('btn-cancel');

        const namaKelasInput = document.getElementById('nama_kelas');
        const guruIdSelect = document.getElementById('tb_guru_id');

        function editKelas(kelas, guruIds) {
            // Scroll to form
            formContainer.scrollIntoView({ behavior: 'smooth' });

            formTitle.textContent = "Edit Data Kelas";
            form.action = "<?php echo e(route('tpq.kelas.update', ':id')); ?>".replace(':id', kelas.id);
            methodField.value = "PUT";
            submitBtn.textContent = "Simpan Perubahan";
            cancelBtn.style.display = "inline-block";

            // Fill inputs
            namaKelasInput.value = kelas.nama_kelas;
            
            if ($('#tb_guru_id').hasClass("select2-hidden-accessible")) {
                $('#tb_guru_id').val(guruIds).trigger('change');
            } else {
                // fallback
                const options = guruIdSelect.options;
                for (let i = 0; i < options.length; i++) {
                    options[i].selected = guruIds.includes(parseInt(options[i].value));
                }
            }
        }

        function resetForm() {
            formTitle.textContent = "Tambah Kelas Baru";
            form.action = "<?php echo e(route('tpq.kelas.store')); ?>";
            methodField.value = "POST";
            submitBtn.textContent = "Simpan Kelas";
            cancelBtn.style.display = "none";

            // Reset inputs
            form.reset();
            if ($('#tb_guru_id').hasClass("select2-hidden-accessible")) {
                $('#tb_guru_id').val(null).trigger('change');
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tb_guru_id').select2({
                placeholder: 'Pilih Guru Pengampu...',
                allowClear: true
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\masjid-baginda\resources\views/tpq/kelas.blade.php ENDPATH**/ ?>