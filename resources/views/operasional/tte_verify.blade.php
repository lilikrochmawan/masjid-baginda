<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi TTE - Masjid Baginda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0fdf4; margin: 0; padding: 20px; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(4,120,87,0.1); border: 1px solid #d1e7dd; max-width: 480px; width: 100%; padding: 32px 24px; text-align: center; }
        .badge-success { background: #dcfce7; color: #15803d; padding: 8px 16px; border-radius: 50px; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; margin-bottom: 24px; border: 1px solid #bbf7d0; }
        .badge-success::before { content: "✓"; font-weight: 900; }
        h1 { font-size: 20px; color: #0f4d36; margin-bottom: 8px; font-weight: 800; }
        .subtitle { color: #64748b; font-size: 14px; margin-bottom: 28px; }
        
        .info-box { border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 20px 0; margin-bottom: 28px; text-align: left; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-val { color: #0f172a; font-weight: 700; text-align: right; }
        
        .footer-note { font-size: 12px; color: #64748b; line-height: 1.5; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

    <div class="card">
        <div class="badge-success">
            Tanda Tangan Elektronik Valid
        </div>
        
        <h1>Verifikasi Dokumen Takmir</h1>
        <div class="subtitle">Sistem Informasi Manajemen Masjid Baginda</div>
        
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Nomor Surat</span>
                <span class="info-val">{{ $surat->nomor_surat }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Perihal</span>
                <span class="info-val">{{ $surat->perihal }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Surat</span>
                <span class="info-val">{{ $surat->tanggal_surat->format('d M Y') }}</span>
            </div>
            <div class="info-row" style="border-top:1px dashed #e2e8f0; margin-top:12px; padding-top:12px;">
                <span class="info-label">Penandatangan</span>
                <span class="info-val" style="color: #047857;">{{ $signerName }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jabatan</span>
                <span class="info-val">{{ $signerRole }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal TTE</span>
                <span class="info-val">{{ $tanggalSign }}</span>
            </div>
        </div>
        
        <div class="footer-note">
            Pernyataan ini dihasilkan secara otomatis oleh sistem administrasi Masjid Baginda sebagai bukti penandatanganan elektronik yang sah.
        </div>
    </div>

</body>
</html>
