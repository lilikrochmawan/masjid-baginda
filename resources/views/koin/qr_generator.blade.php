<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator QR Code - Koin Baginda</title>
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
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px; }
        .page-title h1 { color: #0f4d36; font-size: 26px; font-weight: 700; }
        
        .card { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 16px rgba(15,60,40,0.07); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px; }
        .card-title { color: #0f4d36; font-size: 18px; font-weight: 700; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 8px; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 3px 10px rgba(16, 185, 129, 0.2); }
        .btn-primary:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); transform: translateY(-1px); }
        .btn-primary:disabled { background: #a7f3d0; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-secondary { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }

        /* Table */
        .table-wrapper { overflow-x: auto; margin-top: 10px; border-radius: 8px; border: 1px solid #e6f4ed; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px 14px; border-bottom: 1px solid #e6f4ed; text-align: left; color: #164a3f; font-size: 13px; }
        table th { background: #effff6; font-weight: 700; color: #0f4d36; }
        table tbody tr:hover { background: #f9fffb; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 600; }
        .badge-code { background: #e0f8e8; color: #0f5132; border: 1px solid #a7f3d0; }
        .badge-owner { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .badge-none { background: #f3f4f6; color: #6b7280; }

        /* Search input */
        .search-input { padding: 8px 12px; border: 1px solid #cfe9dd; border-radius: 8px; font-size: 13px; width: 220px; outline: none; background: #f8fffb; color: #114e37; }
        .search-input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }

        /* Custom Checkbox */
        .chk-container { display: block; position: relative; padding-left: 20px; cursor: pointer; user-select: none; }
        .chk-container input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .checkmark { position: absolute; top: 2px; left: 0; height: 16px; width: 16px; background-color: #eee; border-radius: 4px; border: 1px solid #cbd5e1; }
        .chk-container:hover input ~ .checkmark { background-color: #ccc; }
        .chk-container input:checked ~ .checkmark { background-color: #10b981; border-color: #059669; }
        .checkmark:after { content: ""; position: absolute; display: none; }
        .chk-container input:checked ~ .checkmark:after { display: block; }
        .chk-container .checkmark:after { left: 5px; top: 1px; width: 4px; height: 8px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); }

        /* ── Modal ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
        .modal.open { display: flex; opacity: 1; }
        .modal-content { background: white; border-radius: 16px; width: 90%; max-width: 400px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); transform: scale(0.9); transition: transform 0.3s ease; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .modal.open .modal-content { transform: scale(1); }
        .modal-header { width: 100%; display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .modal-title { font-size: 18px; font-weight: 700; color: #0f4d36; }
        .modal-close { background: none; border: none; font-size: 20px; cursor: pointer; color: #6b7280; }
        .modal-close:hover { color: #111827; }
        
        .qr-display-box { padding: 16px; border: 1px solid #e5e7eb; border-radius: 12px; background: #f9fafb; margin-bottom: 16px; display: inline-flex; align-items: center; justify-content: center; }
        .qr-info-meta { margin-bottom: 20px; width: 100%; background: #f0fdf4; border: 1px solid #bcf0da; border-radius: 8px; padding: 10px 14px; text-align: left; }
        .qr-info-item { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px; }
        .qr-info-item:last-child { margin-bottom: 0; }
        .qr-info-label { font-weight: 600; color: #065f46; }
        .qr-info-val { font-family: monospace; color: #111827; word-break: break-all; }
        
        .modal-actions { display: flex; gap: 10px; width: 100%; justify-content: center; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { display: flex; }
            .main { margin-left: 0; padding: 16px 14px 30px; }
            .page-title h1 { font-size: 22px; }
            .card { padding: 16px; }
            .card-header { flex-direction: column; align-items: stretch; }
            .search-input { width: 100%; }
        }
    </style>
    <script src="{{ asset('vendor/qrcode.min.js') }}"></script>
    <!-- Fallback if library failed to download, loads dynamically -->
    <script>
        if (typeof QRCode === 'undefined') {
            document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>');
        }
    </script>
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
            <a href="{{ route('koin.scan') }}">
                <span class="nav-icon">📷</span> Scan
            </a>
            @endif
            @if(auth()->user()->hasAccess('koin.qr.generate'))
            <a href="{{ route('koin.qr.generate') }}" class="active">
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
        <span class="topbar-brand">Generator QR</span>
        <button class="topbar-toggle" id="sidebar-toggle">☰</button>
    </div>

    <!-- Main Content -->
    <main class="main">
        <div class="page-header">
            <div class="page-title">
                <h1>Generator QR Code</h1>
            </div>
            <div>
                <button class="btn btn-primary" id="btn-batch-print" disabled>
                    <span>🖨️</span> Cetak Massal (<span id="selected-count">0</span>)
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Daftar Kaleng (Database)</div>
                <div>
                    <input type="text" id="search-box" class="search-input" placeholder="Cari kode/nama/pemilik...">
                </div>
            </div>

            <div class="table-wrapper">
                <table id="kaleng-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <label class="chk-container">
                                    <input type="checkbox" id="check-all">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th style="width: 120px;">Kode Kaleng</th>
                            <th>Nama Kaleng</th>
                            <th>Pemilik Terakhir</th>
                            <th>Deskripsi</th>
                            <th style="width: 140px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kalengs as $kaleng)
                            <tr data-kode="{{ $kaleng->kode_kaleng }}" data-signature="{{ $kaleng->signature }}">
                                <td style="text-align: center;">
                                    <label class="chk-container">
                                        <input type="checkbox" class="chk-item" value="{{ $kaleng->kode_kaleng }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                                <td><span class="badge badge-code">{{ $kaleng->kode_kaleng }}</span></td>
                                <td><strong>{{ $kaleng->nama_kaleng }}</strong></td>
                                <td>
                                    @if($kaleng->latestPemilik)
                                        <span class="badge badge-owner">{{ $kaleng->latestPemilik->nama }}</span>
                                    @else
                                        <span class="badge badge-none">- Belum Ada -</span>
                                    @endif
                                </td>
                                <td><span style="color:#6b7280; font-size:12px;">{{ $kaleng->deskripsi ?: '-' }}</span></td>
                                <td style="text-align: center;">
                                    <button class="btn btn-primary btn-sm btn-generate" 
                                            data-kode="{{ $kaleng->kode_kaleng }}"
                                            data-signature="{{ $kaleng->signature }}"
                                            data-nama="{{ $kaleng->nama_kaleng }}"
                                            data-pemilik="{{ $kaleng->latestPemilik ? $kaleng->latestPemilik->nama : '-' }}">
                                        <span>⚙️</span> Buat QR
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #6b7280; padding: 24px 0;">
                                    Tidak ada data kaleng di database. Silakan tambahkan melalui menu Inventori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Detail QR -->
    <div class="modal" id="qr-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">QR Code Kaleng</span>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            
            <div class="qr-display-box" id="modal-qr-container">
                <!-- QR Code rendered here -->
            </div>

            <div class="qr-info-meta">
                <div class="qr-info-item">
                    <span class="qr-info-label">Kode Kaleng</span>
                    <span class="qr-info-val" id="meta-kode">-</span>
                </div>
                <div class="qr-info-item">
                    <span class="qr-info-label">Nama</span>
                    <span class="qr-info-val" id="meta-nama">-</span>
                </div>
                <div class="qr-info-item">
                    <span class="qr-info-label">Pemilik</span>
                    <span class="qr-info-val" id="meta-pemilik">-</span>
                </div>
                <div class="qr-info-item">
                    <span class="qr-info-label">Signature (HMAC)</span>
                    <span class="qr-info-val" id="meta-sig">-</span>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-secondary" id="btn-download-qr">
                    <span>💾</span> Unduh PNG
                </button>
                <button class="btn btn-primary" id="btn-print-qr">
                    <span>🖨️</span> Cetak
                </button>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
            overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
        }

        // Search functionality
        const searchBox = document.getElementById('search-box');
        const tableRows = document.querySelectorAll('#kaleng-table tbody tr');
        if (searchBox) {
            searchBox.addEventListener('keyup', function() {
                const term = this.value.toLowerCase().trim();
                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Checkbox management
        const checkAll = document.getElementById('check-all');
        const chkItems = document.querySelectorAll('.chk-item');
        const btnBatchPrint = document.getElementById('btn-batch-print');
        const selectedCountEl = document.getElementById('selected-count');

        function updateBatchButton() {
            const checkedCount = document.querySelectorAll('.chk-item:checked').length;
            if (selectedCountEl) selectedCountEl.innerText = checkedCount;
            if (btnBatchPrint) {
                btnBatchPrint.disabled = checkedCount === 0;
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                const isChecked = this.checked;
                chkItems.forEach(item => {
                    if (item.closest('tr').style.display !== 'none') {
                        item.checked = isChecked;
                    }
                });
                updateBatchButton();
            });
        }

        chkItems.forEach(item => {
            item.addEventListener('change', updateBatchButton);
        });

        // Modal Elements
        const qrModal = document.getElementById('qr-modal');
        const modalClose = document.getElementById('modal-close');
        const modalQrContainer = document.getElementById('modal-qr-container');
        const metaKode = document.getElementById('meta-kode');
        const metaNama = document.getElementById('meta-nama');
        const metaPemilik = document.getElementById('meta-pemilik');
        const metaSig = document.getElementById('meta-sig');
        
        const btnDownloadQr = document.getElementById('btn-download-qr');
        const btnPrintQr = document.getElementById('btn-print-qr');

        let activeQrCode = null;
        let activeKode = '';
        let activeSignature = '';
        let activeNama = '';
        let activePemilik = '';

        function openModal() {
            qrModal.classList.add('open');
        }

        function closeModal() {
            qrModal.classList.remove('open');
            modalQrContainer.innerHTML = '';
            activeQrCode = null;
        }

        if (modalClose) modalClose.addEventListener('click', closeModal);
        window.addEventListener('click', (e) => {
            if (e.target === qrModal) closeModal();
        });

        // Single QR Generation
        document.querySelectorAll('.btn-generate').forEach(btn => {
            btn.addEventListener('click', function() {
                activeKode = this.getAttribute('data-kode');
                activeSignature = this.getAttribute('data-signature');
                activeNama = this.getAttribute('data-nama');
                activePemilik = this.getAttribute('data-pemilik');

                metaKode.innerText = activeKode;
                metaNama.innerText = activeNama;
                metaPemilik.innerText = activePemilik;
                metaSig.innerText = activeSignature;

                modalQrContainer.innerHTML = '';
                
                // Combined value: KODE|SIGNATURE
                const qrValue = `${activeKode}|${activeSignature}`;

                activeQrCode = new QRCode(modalQrContainer, {
                    text: qrValue,
                    width: 180,
                    height: 180,
                    colorDark : "#0f4d36",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });

                openModal();
            });
        });

        // Download QR as PNG
        if (btnDownloadQr) {
            btnDownloadQr.addEventListener('click', () => {
                // Find canvas or img elements inside container
                const canvas = modalQrContainer.querySelector('canvas');
                const img = modalQrContainer.querySelector('img');
                
                let imgSrc = '';
                if (canvas) {
                    imgSrc = canvas.toDataURL("image/png");
                } else if (img) {
                    imgSrc = img.src;
                }

                if (imgSrc) {
                    const link = document.createElement('a');
                    link.href = imgSrc;
                    link.download = `QR_${activeKode}.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    alert('Gagal mendownload gambar QR Code.');
                }
            });
        }

        // Print Single QR Code
        if (btnPrintQr) {
            btnPrintQr.addEventListener('click', () => {
                const canvas = modalQrContainer.querySelector('canvas');
                const img = modalQrContainer.querySelector('img');
                
                let imgSrc = '';
                if (canvas) {
                    imgSrc = canvas.toDataURL("image/png");
                } else if (img) {
                    imgSrc = img.src;
                }

                if (!imgSrc) {
                    alert('QR Code belum siap untuk dicetak.');
                    return;
                }

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Cetak QR Code ${activeKode}</title>
                        <style>
                            body {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                height: 100vh;
                                margin: 0;
                                font-family: sans-serif;
                                text-align: center;
                            }
                            .qr-card {
                                border: 2px solid #000;
                                border-radius: 12px;
                                padding: 20px;
                                max-width: 250px;
                            }
                            img {
                                width: 200px;
                                height: 200px;
                            }
                            .kode {
                                font-size: 20px;
                                font-weight: bold;
                                margin-top: 10px;
                                letter-spacing: 1px;
                            }
                            .detail {
                                font-size: 11px;
                                color: #555;
                                margin-top: 4px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="qr-card">
                            <div style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">KOIN BAGINDA</div>
                            <img src="${imgSrc}" />
                            <div class="kode">${activeKode}</div>
                            <div class="detail">${activeNama}</div>
                        </div>
                        <script>
                            window.onload = function() {
                                window.print();
                                setTimeout(function() { window.close(); }, 500);
                            };
                        <\/script>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            });
        }

        // Batch Printing
        if (btnBatchPrint) {
            btnBatchPrint.addEventListener('click', () => {
                const checkedBoxes = document.querySelectorAll('.chk-item:checked');
                if (checkedBoxes.length === 0) return;

                const selectedData = [];
                checkedBoxes.forEach(chk => {
                    const row = chk.closest('tr');
                    const kode = row.getAttribute('data-kode');
                    const signature = row.getAttribute('data-signature');
                    const nama = row.querySelector('td:nth-child(3)').innerText;
                    
                    selectedData.push({ kode, signature, nama });
                });

                const printWindow = window.open('', '_blank');
                
                // Construct batch print document
                let html = `
                    <html>
                    <head>
                        <title>Cetak Massal QR Code Koin Baginda</title>
                        <style>
                            @page {
                                size: A4;
                                margin: 15mm;
                            }
                            body {
                                font-family: sans-serif;
                                margin: 0;
                                padding: 0;
                            }
                            .grid-container {
                                display: grid;
                                grid-template-columns: repeat(3, 1fr);
                                gap: 20px;
                            }
                            .qr-card {
                                border: 1px solid #ccc;
                                border-radius: 8px;
                                padding: 12px;
                                text-align: center;
                                page-break-inside: avoid;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                background: #fff;
                            }
                            .title {
                                font-size: 11px;
                                font-weight: bold;
                                margin-bottom: 6px;
                                color: #0f4d36;
                            }
                            .qr-placeholder {
                                width: 140px;
                                height: 140px;
                                margin-bottom: 8px;
                            }
                            .kode {
                                font-size: 15px;
                                font-weight: bold;
                            }
                            .nama {
                                font-size: 10px;
                                color: #555;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                width: 100%;
                            }
                            .sig {
                                font-size: 8px;
                                font-family: monospace;
                                color: #888;
                                margin-top: 4px;
                            }
                        </style>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>
                    </head>
                    <body>
                        <div class="grid-container">
                `;

                selectedData.forEach((item, index) => {
                    html += `
                        <div class="qr-card">
                            <div class="title">🥫 KOIN BAGINDA</div>
                            <div class="qr-placeholder" id="qr-batch-${index}"></div>
                            <div class="kode">${item.kode}</div>
                            <div class="nama">${item.nama}</div>
                        </div>
                    `;
                });

                html += `
                        </div>
                        <script>
                            window.onload = function() {
                                const data = ${JSON.stringify(selectedData)};
                                data.forEach((item, index) => {
                                    const val = item.kode + '|' + item.signature;
                                    new QRCode(document.getElementById('qr-batch-' + index), {
                                        text: val,
                                        width: 140,
                                        height: 140,
                                        colorDark : "#000000",
                                        colorLight : "#ffffff",
                                        correctLevel : QRCode.CorrectLevel.M
                                    });
                                });
                                
                                // Delay slightly for QR generation to complete before printing
                                setTimeout(function() {
                                    window.print();
                                    setTimeout(function() { window.close(); }, 500);
                                }, 800);
                            };
                        <\/script>
                    </body>
                    </html>
                `;

                printWindow.document.write(html);
                printWindow.document.close();
            });
        }
    </script>
</body>
</html>
