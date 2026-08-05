<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pemasukan Koin - {{ $periodeText }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background: #ffffff;
            margin: 0;
            padding: 30px;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px double #059669;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo {
            height: 70px;
            width: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .header-title h1 {
            font-size: 24px;
            margin: 0;
            color: #047857;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-title p {
            font-size: 13px;
            margin: 4px 0 0;
            color: #475569;
            font-weight: 500;
        }

        .header-right {
            text-align: right;
        }

        .header-right p {
            font-size: 11px;
            margin: 2px 0;
            color: #64748b;
        }

        .laporan-info {
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .laporan-info-item {
            font-size: 13px;
            color: #334155;
        }

        .laporan-info-item strong {
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11.5px;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: 800;
            font-size: 14px;
            background-color: #ecfdf5 !important;
            color: #065f46;
            border-top: 2px solid #059669;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #475569;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-space {
            height: 75px;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .laporan-info {
                background: none;
                border: 1px solid #cbd5e1;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <img src="{{ $logoImage }}" alt="Logo" class="header-logo">
            <div class="header-title">
                <h1>Masjid Baginda</h1>
                <p>Laporan Pemasukan Koin Baginda</p>
            </div>
        </div>
        <div class="header-right">
            <p>Tanggal Cetak: {{ now()->format('d M Y') }}</p>
            <p>Oleh: {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="laporan-info">
        <div class="laporan-info-item">
            Jenis Laporan: <strong>Laporan Global ({{ ucfirst($type) }})</strong>
        </div>
        <div class="laporan-info-item">
            Periode: <strong>{{ $periodeText }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 60px;">#</th>
                <th style="width: 150px;">Tanggal</th>
                <th>Keterangan</th>
                <th style="width: 180px;">Petugas Penerima</th>
                <th style="width: 180px;" class="text-right">Jumlah Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penerimaan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal_penerimaan)->format('d M Y') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->user?->name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">Tidak ada data pemasukan pada periode ini.</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Penerimaan:</td>
                <td class="text-right">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Ketua Takmir</p>
            <div class="signature-space"></div>
            <p>_______________________</p>
        </div>
        <div class="signature-box">
            <p>Dibuat Oleh,</p>
            <p>Petugas Koin</p>
            <div class="signature-space"></div>
            <p><strong>{{ auth()->user()->name }}</strong></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
