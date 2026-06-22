<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah User - Baginda</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: radial-gradient(circle at 50% 0%, #f0fdf4 0%, #f8fafc 100%);
            min-height: 100vh;
            color: #1e293b;
        }

        .navbar {
            background: rgba(16, 185, 129, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: white;
            padding: 16px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-menu a,
        .navbar-menu button {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 600;
        }

        .navbar-menu a:hover,
        .navbar-menu button:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 24px 60px;
        }

        .page-title {
            margin-bottom: 24px;
        }

        .page-title h1 {
            font-size: 32px;
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(16, 185, 129, 0.08);
        }

        .card h2 {
            color: #0f172a;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.4px;
            position: relative;
            padding-bottom: 8px;
        }

        .card h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2.5px;
            background: #10b981;
            border-radius: 2px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-weight: 600;
            font-size: 13.5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .form-group input:disabled {
            background: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .button-primary,
        .button-secondary {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .button-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.15);
        }

        .button-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);
        }

        .button-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .button-secondary:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .note {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 6px;
        }

        /* ── Permissions Checklist Styling ── */
        .permission-section-title {
            margin-top: 28px;
            margin-bottom: 14px;
            font-size: 15px;
            color: #0f172a;
            font-weight: 700;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            position: relative;
        }
        
        .permission-section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 40px;
            height: 2px;
            background: #10b981;
        }

        .permission-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }
        
        @media (min-width: 500px) {
            .permission-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .permission-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px;
            transition: all 0.2s ease;
        }

        .permission-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        
        .permission-parent {
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .permission-parent input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            accent-color: #10b981;
            cursor: pointer;
        }

        .parent-label {
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 0 !important;
            font-size: 13.5px !important;
            cursor: pointer;
        }
        
        .permission-children {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-left: 4px;
        }
        
        .permission-child {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .permission-child input[type="checkbox"] {
            width: 16px !important;
            height: 16px !important;
            accent-color: #10b981;
            cursor: pointer;
        }

        .permission-child label {
            font-weight: 500 !important;
            color: #475569 !important;
            margin-bottom: 0 !important;
            font-size: 12.5px !important;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .form-actions {
                flex-direction: column;
            }

            .button-primary,
            .button-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand"><span>🕌</span> Masjid Baginda</div>
        <div class="navbar-menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('users.index') }}">Manajemen User</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="page-title">
            <h1>Ubah User</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <h2>Ubah Password dan Hak Akses</h2>

            <form action="{{ route('users.update', $editUser->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" value="{{ $editUser->name }}" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ $editUser->email }}" disabled>
                </div>

                <div class="form-group">
                    <label for="tb_hakakses_id">Hak Akses</label>
                    <select id="tb_hakakses_id" name="tb_hakakses_id" required>
                        <option value="">Pilih hak akses</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $editUser->tb_hakakses_id == $role->id ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role->nama_hakakses)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diganti">
                    <div class="note">Isi hanya jika Anda ingin mengganti password user ini.</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Kosongkan jika tidak diganti">
                </div>

                <div class="permission-section-title">Hak Akses Modul & Submodul</div>
                <div class="permission-grid">
                    <!-- Card Modul: Manajemen User -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_users" name="akses_modul[]" value="users" class="parent-checkbox" {{ $editUser->hasAccess('users') ? 'checked' : '' }}>
                            <label for="mod_users" class="parent-label">Manajemen User</label>
                        </div>
                    </div>

                    <!-- Card Modul: Koin Baginda -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_koin" name="akses_modul[]" value="koin" class="parent-checkbox" {{ $editUser->hasAccess('koin') ? 'checked' : '' }}>
                            <label for="mod_koin" class="parent-label">Koin Baginda</label>
                        </div>
                        <div class="permission-children">
                            <div class="permission-child">
                                <input type="checkbox" id="sub_koin_inv" name="akses_modul[]" value="koin.inventory" class="child-checkbox" {{ $editUser->hasAccess('koin.inventory') ? 'checked' : '' }}>
                                <label for="sub_koin_inv">Inventori Kaleng</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_koin_pem" name="akses_modul[]" value="koin.pemilik" class="child-checkbox" {{ $editUser->hasAccess('koin.pemilik') ? 'checked' : '' }}>
                                <label for="sub_koin_pem">Pemilik Kaleng</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_koin_scan" name="akses_modul[]" value="koin.scan" class="child-checkbox" {{ $editUser->hasAccess('koin.scan') ? 'checked' : '' }}>
                                <label for="sub_koin_scan">Transaksi Scan</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_koin_pen" name="akses_modul[]" value="koin.penerimaan" class="child-checkbox" {{ $editUser->hasAccess('koin.penerimaan') ? 'checked' : '' }}>
                                <label for="sub_koin_pen">Penerimaan Kaleng</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_koin_lap" name="akses_modul[]" value="koin.laporan" class="child-checkbox" {{ $editUser->hasAccess('koin.laporan') ? 'checked' : '' }}>
                                <label for="sub_koin_lap">Laporan Koin</label>
                            </div>
                        </div>
                    </div>

                    <!-- Card Modul: Data Operasional -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_op" name="akses_modul[]" value="operasional" class="parent-checkbox" {{ $editUser->hasAccess('operasional') ? 'checked' : '' }}>
                            <label for="mod_op" class="parent-label">Data Operasional</label>
                        </div>
                        <div class="permission-children">
                            <div class="permission-child">
                                <input type="checkbox" id="sub_op_struk" name="akses_modul[]" value="operasional.struktur" class="child-checkbox" {{ $editUser->hasAccess('operasional.struktur') ? 'checked' : '' }}>
                                <label for="sub_op_struk">Struktur Organisasi</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_op_inv" name="akses_modul[]" value="operasional.inventaris" class="child-checkbox" {{ $editUser->hasAccess('operasional.inventaris') ? 'checked' : '' }}>
                                <label for="sub_op_inv">Inventarisasi Barang</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_op_surat" name="akses_modul[]" value="operasional.surat" class="child-checkbox" {{ $editUser->hasAccess('operasional.surat') ? 'checked' : '' }}>
                                <label for="sub_op_surat">Administrasi Persuratan</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_op_rencana" name="akses_modul[]" value="operasional.rencana" class="child-checkbox" {{ $editUser->hasAccess('operasional.rencana') ? 'checked' : '' }}>
                                <label for="sub_op_rencana">Rencana Kerja Seksi</label>
                            </div>
                        </div>
                    </div>

                    <!-- Card Modul: Keuangan -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_keu" name="akses_modul[]" value="keuangan" class="parent-checkbox" {{ $editUser->hasAccess('keuangan') ? 'checked' : '' }}>
                            <label for="mod_keu" class="parent-label">Keuangan</label>
                        </div>
                        <div class="permission-children">
                            <div class="permission-child">
                                <input type="checkbox" id="sub_keu_tx" name="akses_modul[]" value="keuangan.transaksi" class="child-checkbox" {{ $editUser->hasAccess('keuangan.transaksi') ? 'checked' : '' }}>
                                <label for="sub_keu_tx">Kas & Transaksi</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_keu_lap" name="akses_modul[]" value="keuangan.laporan" class="child-checkbox" {{ $editUser->hasAccess('keuangan.laporan') ? 'checked' : '' }}>
                                <label for="sub_keu_lap">Laporan Keuangan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Card Modul: Manajemen TPQ -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_tpq" name="akses_modul[]" value="tpq" class="parent-checkbox" {{ $editUser->hasAccess('tpq') ? 'checked' : '' }}>
                            <label for="mod_tpq" class="parent-label">Manajemen TPQ</label>
                        </div>
                        <div class="permission-children">
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_guru" name="akses_modul[]" value="tpq.guru" class="child-checkbox" {{ $editUser->hasAccess('tpq.guru') ? 'checked' : '' }}>
                                <label for="sub_tpq_guru">Data Guru</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_kelas" name="akses_modul[]" value="tpq.kelas" class="child-checkbox" {{ $editUser->hasAccess('tpq.kelas') ? 'checked' : '' }}>
                                <label for="sub_tpq_kelas">Data Kelas</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_santri" name="akses_modul[]" value="tpq.santri" class="child-checkbox" {{ $editUser->hasAccess('tpq.santri') ? 'checked' : '' }}>
                                <label for="sub_tpq_santri">Data Santri</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_abs" name="akses_modul[]" value="tpq.absensi" class="child-checkbox" {{ $editUser->hasAccess('tpq.absensi') ? 'checked' : '' }}>
                                <label for="sub_tpq_abs">Absensi Santri</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_lap" name="akses_modul[]" value="tpq.laporan" class="child-checkbox" {{ $editUser->hasAccess('tpq.laporan') ? 'checked' : '' }}>
                                <label for="sub_tpq_lap">Laporan Absensi</label>
                            </div>
                            <div class="permission-child">
                                <input type="checkbox" id="sub_tpq_keu" name="akses_modul[]" value="tpq.keuangan" class="child-checkbox" {{ $editUser->hasAccess('tpq.keuangan') ? 'checked' : '' }}>
                                <label for="sub_tpq_keu">Keuangan TPQ</label>
                            </div>
                        </div>
                    </div>

                    <!-- Card Modul: Pengaturan Sistem -->
                    <div class="permission-card">
                        <div class="permission-parent">
                            <input type="checkbox" id="mod_about" name="akses_modul[]" value="tentang" class="parent-checkbox" {{ $editUser->hasAccess('tentang') ? 'checked' : '' }}>
                            <label for="mod_about" class="parent-label">Pengaturan Sistem</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('users.index') }}" class="button-secondary">Kembali</a>
                    <button type="submit" class="button-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Parent checkboxes
            const parentCheckboxes = document.querySelectorAll('.parent-checkbox');
            parentCheckboxes.forEach(parent => {
                parent.addEventListener('change', function () {
                    const card = this.closest('.permission-card');
                    const children = card.querySelectorAll('.child-checkbox');
                    children.forEach(child => {
                        child.checked = this.checked;
                    });
                });
            });

            // Child checkboxes
            const childCheckboxes = document.querySelectorAll('.child-checkbox');
            childCheckboxes.forEach(child => {
                child.addEventListener('change', function () {
                    if (this.checked) {
                        const card = this.closest('.permission-card');
                        const parent = card.querySelector('.parent-checkbox');
                        if (parent) parent.checked = true;
                    }
                });
            });
        });
    </script>
</body>
</html>
