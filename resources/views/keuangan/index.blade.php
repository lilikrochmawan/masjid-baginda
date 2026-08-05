<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Baginda</title>
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
        .section h2 { font-size: 18px; color: #0f4d36; margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: 1.2fr .8fr; gap: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #d1e7dd; font-size: 14px; color: #103a2d; background: #fbfffe; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .disabled-select { pointer-events: none; opacity: 0.65; }
        .button-primary { display: inline-block; padding: 12px 20px; border-radius: 12px; background: #10b981; color: white; border: none; font-weight: 700; cursor: pointer; transition: transform .2s ease; }
        .button-primary:hover { transform: translateY(-1px); }
        .alert { border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 14px; }
        .summary-card { background: #effff6; padding: 14px 12px; border-radius: 12px; }
        .summary-card span { display: block; font-size: 11px; color: #166534; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .4px; }
        .summary-card strong { display: block; font-size: 24px; font-weight: 700; color: #064e3b; }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; font-size: 13px; color: #164a3f; }
        th { background: #f0fdf4; font-weight: 700; }
        tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #d1fae5; color: #0f5132; font-size: 12px; font-weight: 700; }
        .confirm-button { padding: 8px 12px; border-radius: 8px; border: none; background: #0f766e; color: white; cursor: pointer; font-size: 12px; }
        .confirm-button:hover { opacity: 0.9; }

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
            <span>💰</span> Keuangan
        </div>
        <nav class="sidebar-nav">
            @if(auth()->user()->hasAccess('keuangan.transaksi'))
            <a href="{{ route('keuangan.index') }}" class="active">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @endif
            @if(auth()->user()->hasAccess('keuangan.laporan'))
            <a href="{{ route('keuangan.laporan') }}">
                <span class="nav-icon">📊</span> Laporan
            </a>
            @endif
            <div class="divider"></div>
            @if(auth()->user()->hasAccess('koin'))
            <a href="{{ route('koin.index') }}">
                <span class="nav-icon">🥫</span> Koin Baginda
            </a>
            @endif
            <a href="{{ route('dashboard') }}">
                <span class="nav-icon">⬅️</span> Dashboard
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
        <span class="topbar-brand">Keuangan Baginda</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Modul Keuangan</h1></div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="section">
            <h2>Input Arus Kas</h2>
            <div class="grid">
                <div>
                    <form action="{{ route('keuangan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal_kas">Tanggal</label>
                            <input type="date" id="tanggal_kas" name="tanggal_kas" value="{{ old('tanggal_kas', date('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe Arus Kas</label>
                            <select id="tipe" name="tipe" required>
                                <option value="">Pilih tipe</option>
                                <option value="masuk" {{ old('tipe') === 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="keluar" {{ old('tipe') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="tb_penerimaan_kaleng_id">Penerimaan Kaleng (opsional)</label>
                            <select id="tb_penerimaan_kaleng_id" name="tb_penerimaan_kaleng_id">
                                <option value="">Tidak terkait penerimaan</option>
                                @foreach($penerimaanOptions as $option)
                                    <option value="{{ $option->id }}" data-amount="{{ $option->jumlah }}" {{ old('tb_penerimaan_kaleng_id') == $option->id ? 'selected' : '' }}>
                                        {{ $option->tanggal_penerimaan }} - {{ $option->jumlah }} - {{ $option->user?->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                        </div>
                        <button type="submit" class="button-primary">Simpan Kas</button>
                    </form>
                </div>

                <div>
                    <div class="summary-grid">
                        <div class="summary-card">
                            <span>Status user</span>
                            <strong>{{ ucfirst($hakakses->nama_hakakses) }}</strong>
                        </div>
                        <div class="summary-card">
                            <span>Pending kas masuk</span>
                            <strong>{{ $pendingKasCount }}</strong>
                        </div>
                    </div>

                    @if($hakakses->nama_hakakses === 'bendahara' && $pendingKas->isNotEmpty())
                        <div class="section" style="margin-top: 16px;">
                            <h2>Notifikasi Konfirmasi</h2>
                            <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">Ada {{ $pendingKasCount }} transaksi kas masuk menunggu konfirmasi.</p>
                            <div class="table-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th>Pengaju</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingKas as $kas)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $kas->tanggal_kas }}</td>
                                                <td>{{ $kas->jumlah }}</td>
                                                <td>{{ $kas->keterangan ?? '-' }}</td>
                                                <td>{{ $kas->user?->name ?? '-' }}</td>
                                                <td>
                                                    <form action="{{ route('keuangan.confirm', $kas->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="confirm-button">Konfirmasi</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Riwayat Kas</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Referensi</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasEntries as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_kas }}</td>
                                <td>{{ ucfirst($item->tipe) }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->penerimaanKaleng?->tanggal_penerimaan ? 'Penerimaan ' . $item->penerimaanKaleng->tanggal_penerimaan : '-' }}</td>
                                <td>{{ $item->user?->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }

        // Form logic
        const penerimaanSelect = document.getElementById('tb_penerimaan_kaleng_id');
        const tipeSelect       = document.getElementById('tipe');
        const jumlahInput      = document.getElementById('jumlah');
        const keteranganInput  = document.getElementById('keterangan');

        function formatMonthLabel(date) {
            const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            return monthNames[date.getMonth()];
        }

        function setPenerimaanKas() {
            const selectedOption = penerimaanSelect.options[penerimaanSelect.selectedIndex];
            const amount = selectedOption.dataset.amount;
            if (penerimaanSelect.value) {
                tipeSelect.value = 'masuk';
                tipeSelect.classList.add('disabled-select');
                jumlahInput.value = amount || '';
                jumlahInput.readOnly = true;
                const now = new Date();
                keteranganInput.value = 'Penerimaan koin Baginda bulan ' + formatMonthLabel(now);
            } else {
                tipeSelect.classList.remove('disabled-select');
                jumlahInput.readOnly = false;
                jumlahInput.value = '{{ old('jumlah') ?? '' }}';
                keteranganInput.value = '{{ old('keterangan') ?? '' }}';
            }
        }

        tipeSelect.addEventListener('change', function() {
            if (penerimaanSelect.value) tipeSelect.value = 'masuk';
        });

        if (penerimaanSelect) {
            penerimaanSelect.addEventListener('change', setPenerimaanKas);
            setPenerimaanKas();
        }
    </script>
</body>
</html>
