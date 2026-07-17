<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Scan - Koin Baginda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f3faf7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

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
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }
        .grid { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 16px rgba(15,60,40,0.07); }
        .card h2 { color: #0f4d36; margin-bottom: 14px; font-size: 18px; }
        .alert { padding: 12px 14px; border-radius: 10px; margin-bottom: 14px; font-size: 13px; }
        .alert-success { background: #d1fae5; color: #0f5132; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .scan-box { min-height: 280px; padding: 16px; border: 2px dashed #b7f3d0; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; }
        .scan-btn { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 10px; padding: 10px 16px; cursor: pointer; font-weight: 700; font-size: 13px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; margin-bottom: 6px; color: #164a3f; font-weight: 600; font-size: 13px; }
        .form-group input, .form-group select { width: 100%; padding: 11px 12px; border-radius: 8px; border: 1px solid #cfe9dd; background: #f8fffb; color: #114e37; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 10px; padding: 12px 20px; cursor: pointer; font-weight: 700; font-size: 13px; transition: all 0.3s ease; box-shadow: 0 3px 10px rgba(16, 185, 129, 0.25); width: 100%; }
        .btn-primary:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
        .btn-primary:active { transform: translateY(1px); }
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; margin-top: 14px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 11px 10px; border-bottom: 1px solid #e6f4ed; text-align: left; color: #164a3f; font-size: 12px; }
        table th { background: #effff6; font-weight: 700; }
        table tbody tr:hover { background: #f3fff8; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 999px; background: #e0f8e8; color: #0f5132; font-size: 11px; font-weight: 600; }
        .note { color: #295339; font-size: 12px; text-align: center; }
        @media (max-width: 1024px) {
            .grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 14px 12px 25px; }
            .page-title h1 { font-size: 22px; }
            .grid { gap: 12px; }
            .card { padding: 16px 14px; }
            .scan-box { min-height: 240px; padding: 14px; gap: 10px; }
            .scan-btn { width: 100%; padding: 11px 12px; font-size: 13px; }
            .form-group input { font-size: 16px; padding: 12px; }
            .form-actions { margin-top: 16px; }
            .table-wrapper { margin-top: 12px; }
            table th, table td { padding: 9px 7px; font-size: 11px; }
        }
        @media (max-width: 480px) {
            .page-title h1 { font-size: 20px; }
            .card { padding: 12px 10px; }
            .card h2 { font-size: 16px; margin-bottom: 12px; }
            .scan-box { min-height: 200px; }
            table th, table td { padding: 8px 5px; font-size: 10px; }
        }
    </style>
    <script src="{{ asset('vendor/html5-qrcode.min.js') }}"></script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>🥫</span> Koin Baginda
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('koin.index') }}">
                <span class="nav-icon">🏠</span> Beranda
            </a>
            @if(auth()->user()->hasAccess('koin.inventory'))
<a href="{{ route('koin.inventory') }}">
                <span class="nav-icon">📦</span> Inventori
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.pemilik'))
<a href="{{ route('koin.pemilik') }}">
                <span class="nav-icon">👤</span> Pemilik
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.scan'))
<a href="{{ route('koin.scan') }}" class="active">
                <span class="nav-icon">📷</span> Scan
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.qr.generate'))
<a href="{{ route('koin.qr.generate') }}">
                <span class="nav-icon">🖼️</span> Generate QR
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.penerimaan'))
<a href="{{ route('koin.penerimaan.create') }}">
                <span class="nav-icon">🧾</span> Penerimaan
            </a>
@endif
            @if(auth()->user()->hasAccess('koin.laporan'))
<a href="{{ route('koin.laporan') }}">
                <span class="nav-icon">📊</span> Laporan
            </a>
@endif
            <div class="divider"></div>
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
        <span class="topbar-brand">Transaksi Scan</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-title"><h1>Transaksi Scan</h1></div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">⚠️ {{ session('error') }}</div>
        @endif

        <div class="grid">
            <div class="card">
                <h2>Scan Kaleng</h2>
                <div class="scan-box" id="reader">
                    <p class="note">Tekan tombol untuk buka kamera</p>
                    <div id="scan-status" style="min-height:18px;color:#14573f;font-size:12px;"></div>
                    <div id="library-warning" style="display:none;padding:10px;border-radius:8px;background:#fff6f3;color:#7a2719;margin-bottom:8px;font-size:11px;">
                        Library QR tidak ditemukan. Letakkan <strong>html5-qrcode.min.js</strong> di <code>public/vendor/</code>
                    </div>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;">
                        <button class="scan-btn" id="scan-button" type="button">Buka Kamera</button>
                        <button class="scan-btn" id="stop-button" type="button" style="display:none;background:#6ee7b7;color:#064e3b;">Berhenti</button>
                    </div>
                    <p class="note">Atau masukkan manual</p>
                </div>

                <form action="{{ route('koin.scan.store') }}" method="POST" style="margin-top: 16px;">
                    @csrf
                    <input type="hidden" id="qr_signature" name="qr_signature" value="{{ old('qr_signature') }}">
                    <div class="form-group">
                        <label for="kode_kaleng">Kode Kaleng</label>
                        <input type="text" id="kode_kaleng" name="kode_kaleng" value="{{ old('kode_kaleng') }}" placeholder="BGD00001" readonly style="background: #eef7f4; cursor: not-allowed;" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_ambil">Tanggal Ambil</label>
                        <input type="date" id="tanggal_ambil" name="tanggal_ambil" value="{{ old('tanggal_ambil', now()->format('Y-m-d')) }}" readonly style="background: #eef7f4; cursor: not-allowed;" required>
                    </div>
                    <div class="form-actions" style="margin-top:16px;">
                        <button class="btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h2>Riwayat</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Pemilik</th>
                                <th>Tgl</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td><span class="badge">{{ $transaction->kaleng->kode_kaleng }}</span></td>
                                    <td>{{ $transaction->kaleng->nama_kaleng }}</td>
                                    <td>{{ $transaction->kaleng->latestPemilik?->nama ?? '-' }}</td>
                                    <td>{{ $transaction->tanggal_ambil->format('d M') }}</td>
                                    <td>{{ $transaction->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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

        // QR Scanner
        const statusElement = document.getElementById('scan-status');
        const readerElement = document.getElementById('reader');
        const scanButton    = document.getElementById('scan-button');
        const stopButton    = document.getElementById('stop-button');
        let html5QrCodeInstance = null;
        let isStarting = false;

        function setStatus(message, isError = false) {
            if (!statusElement) return;
            statusElement.textContent = message;
            statusElement.style.color = isError ? '#b91c1c' : '#14573f';
        }

        function loadScript(url) {
            return new Promise((resolve, reject) => {
                const s = document.createElement('script');
                s.src = url;
                s.onload = () => resolve();
                s.onerror = () => reject(new Error('Failed to load ' + url));
                document.head.appendChild(s);
            });
        }

        function chooseRearCameraId(cameras) {
            if (!cameras || cameras.length === 0) return null;
            const rearPattern = /(rear|back|environment|belakang)/i;
            const frontPattern = /(front|selfie|depan)/i;
            let camera = cameras.find(c => c.label && rearPattern.test(c.label));
            if (camera) return camera.id;
            camera = cameras.find(c => c.label && !frontPattern.test(c.label));
            if (camera) return camera.id;
            return cameras[0].id;
        }

        function isMobileDevice() {
            return /Mobi|Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
        }

        function getCameraSelection(cameras) {
            const rearCameraId = chooseRearCameraId(cameras);
            if (isMobileDevice()) {
                return rearCameraId
                    ? { deviceId: { exact: rearCameraId } }
                    : { facingMode: { ideal: 'environment' } };
            }
            return rearCameraId ? { deviceId: { exact: rearCameraId } } : true;
        }

        function resetUI() {
            if (scanButton) {
                scanButton.style.display = 'inline-block';
                scanButton.disabled = false;
            }
            if (stopButton) stopButton.style.display = 'none';
            setStatus('');
            isStarting = false;
        }

        async function stopScanner() {
            if (!html5QrCodeInstance) return;
            try {
                await html5QrCodeInstance.stop();
            } catch (e) {
                console.debug('Error stopping scanner', e);
            }
            try {
                await html5QrCodeInstance.clear();
            } catch (e) {
                console.debug('Error clearing scanner', e);
            }
            html5QrCodeInstance = null;
            resetUI();
        }

        async function clearCurrentScanner() {
            if (!html5QrCodeInstance) return;
            try {
                await html5QrCodeInstance.stop();
            } catch (e) {
                console.debug('Error stopping scanner before fallback', e);
            }
            try {
                await html5QrCodeInstance.clear();
            } catch (e) {
                console.debug('Error clearing scanner before fallback', e);
            }
            html5QrCodeInstance = null;
        }

        async function ensureLibraryLoaded() {
            if (typeof Html5Qrcode !== 'undefined') return;
            setStatus('Memuat library pemindai...');
            try {
                await loadScript('{{ asset('vendor/html5-qrcode.min.js') }}');
                if (typeof Html5Qrcode === 'undefined') {
                    throw new Error('Library lokal tidak tersedia');
                }
            } catch (localError) {
                console.warn('Local library failed, trying fallback', localError);
                try {
                    await loadScript('https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.7/minified/html5-qrcode.min.js');
                } catch (remoteError) {
                    throw new Error('Gagal memuat library pemindai QR.');
                }
            }
        }

        async function startScanner() {
            if (html5QrCodeInstance || isStarting) return;
            isStarting = true;
            if (scanButton) scanButton.disabled = true;
            setStatus('Memeriksa kamera...');

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Kamera tidak tersedia di perangkat ini.');
                setStatus('Perangkat tidak mendukung kamera.', true);
                resetUI();
                return;
            }

            try {
                await ensureLibraryLoaded();
            } catch (err) {
                console.error(err);
                alert(err.message);
                setStatus(err.message, true);
                resetUI();
                return;
            }

            let cameras;
            try {
                cameras = await Html5Qrcode.getCameras();
            } catch (err) {
                console.error('Gagal mengambil daftar kamera', err);
                alert('Gagal mengambil daftar kamera.');
                setStatus('Gagal mengambil daftar kamera.', true);
                resetUI();
                return;
            }

            if (!cameras || cameras.length === 0) {
                alert('Tidak ditemukan kamera pada perangkat ini.');
                setStatus('Tidak ditemukan kamera.', true);
                resetUI();
                return;
            }

            readerElement.innerHTML = '<div id="reader-scanner" style="width:100%;"></div>';
            html5QrCodeInstance = new Html5Qrcode('reader-scanner');
            const selection = getCameraSelection(cameras);
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            if (scanButton) scanButton.style.display = 'none';
            if (stopButton) stopButton.style.display = 'inline-block';
            setStatus('Membuka kamera...');

            try {
                await html5QrCodeInstance.start(
                    selection,
                    config,
                    qrCodeMessage => {
                        const parts = qrCodeMessage.split('|');
                        const kode = parts[0];
                        const sig = parts.length > 1 ? parts[1] : '';
                        const input = document.getElementById('kode_kaleng');
                        const sigInput = document.getElementById('qr_signature');
                        if (input) input.value = kode;
                        if (sigInput) sigInput.value = sig;
                        setStatus('Kode terbaca.');
                        stopScanner();
                    },
                    errorMessage => {
                        setStatus('Mencari QR...');
                        console.debug('Scan error:', errorMessage);
                    }
                );
                setStatus('Sedang memindai...');
                isStarting = false;
            } catch (startErr) {
                console.warn('Gagal memulai scanner dengan pengaturan awal:', startErr);
                if (isMobileDevice()) {
                    try {
                        await clearCurrentScanner();
                        readerElement.innerHTML = '<div id="reader-scanner" style="width:100%;"></div>';
                        html5QrCodeInstance = new Html5Qrcode('reader-scanner');
                        await html5QrCodeInstance.start(
                            { facingMode: { ideal: 'environment' } },
                            config,
                            qrCodeMessage => {
                                const parts = qrCodeMessage.split('|');
                                const kode = parts[0];
                                const sig = parts.length > 1 ? parts[1] : '';
                                const input = document.getElementById('kode_kaleng');
                                const sigInput = document.getElementById('qr_signature');
                                if (input) input.value = kode;
                                if (sigInput) sigInput.value = sig;
                                setStatus('Kode terbaca.');
                                stopScanner();
                            },
                            errorMessage => {
                                setStatus('Mencari QR...');
                                console.debug('Scan error:', errorMessage);
                            }
                        );
                        setStatus('Sedang memindai...');
                        isStarting = false;
                    } catch (fallbackErr) {
                        console.error('Gagal memulai fallback kamera:', fallbackErr);
                        alert('Gagal memulai kamera: ' + (fallbackErr?.message || fallbackErr));
                        setStatus('Gagal memulai kamera.', true);
                        resetUI();
                    }
                } else {
                    console.error('Gagal memulai scanner:', startErr);
                    alert('Gagal memulai kamera: ' + (startErr?.message || startErr));
                    setStatus('Gagal memulai kamera.', true);
                    resetUI();
                }
            }
        }

        if (scanButton) scanButton.addEventListener('click', startScanner);
        if (stopButton) stopButton.addEventListener('click', stopScanner);
        window.addEventListener('beforeunload', () => { if (html5QrCodeInstance) html5QrCodeInstance.clear().catch(()=>{}); });
    </script>
</body>
</html>
