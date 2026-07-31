<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Resmi - {{ $surat->nomor_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; background: #ffffff; color: #000000; padding: 25mm 20mm; font-size: 12pt; line-height: 1.5; }

        /* Kop Surat */
        .kop-surat { text-align: center; border-bottom: 3px double #000000; padding-bottom: 12px; margin-bottom: 25px; }
        .kop-surat h2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; }
        .kop-surat p { font-size: 10pt; line-height: 1.3; font-style: italic; }

        /* Surat Details */
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table td { padding: 4px 0; vertical-align: top; font-size: 11pt; }
        .details-table td.label { width: 100px; }
        .details-table td.colon { width: 15px; text-align: center; }

        .tanggal-surat { text-align: right; margin-bottom: 15px; font-size: 11pt; }
        .tujuan-surat { margin-bottom: 25px; font-size: 11pt; }

        /* Isi Surat */
        .isi-surat { text-align: justify; margin-bottom: 40px; font-size: 11pt; min-height: 250px; }
        .isi-surat p { margin-bottom: 12px; text-indent: 30px; }
        .isi-surat ul, .isi-surat ol { margin-left: 40px; margin-bottom: 12px; }

        /* Signatures (TTE) */
        .signature-section { width: 100%; margin-top: 30px; border-collapse: collapse; page-break-inside: avoid; }
        .signature-section td { text-align: center; vertical-align: top; width: 33.33%; padding: 10px 5px; font-size: 11pt; }
        .sig-space { height: 75px; display: flex; align-items: center; justify-content: center; }
        .sig-image { max-height: 70px; max-width: 150px; }
        .sig-name { font-weight: bold; text-decoration: underline; margin-top: 5px; }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <!-- Floating Print Button (Visible only on screen) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 100;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.15);">Cetak Surat (Print)</button>
    </div>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>{{ $surat->header_title }}</h2>
        <p style="white-space: pre-line;">{{ $surat->header_subtitle }}</p>
    </div>

    <!-- Tanggal Surat -->
    <div class="tanggal-surat">
        Baginda, {{ $surat->tanggal_surat->format('d M Y') }}
    </div>

    <!-- Surat Info Details -->
    <table class="details-table">
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td>{{ $surat->nomor_surat }}</td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td><strong>{{ $surat->perihal }}</strong></td>
        </tr>
    </table>

    <!-- Tujuan Surat -->
    <div class="tujuan-surat">
        Kepada Yth.<br>
        <strong>{{ $surat->tujuan_surat ?? 'Wali Santri / Jamaah Masjid Baginda' }}</strong><br>
        di Tempat
    </div>

    <!-- Isi Surat (HTML render from Quill) -->
    <div class="isi-surat">
        {!! $surat->isi_surat !!}
    </div>

    <!-- Signature TTE Block -->
    <table class="signature-section">
        <tr>
            <td>
                <div>Mengetahui,<br><strong>Penasehat Takmir</strong></div>
                <div class="sig-space">
                    @if($surat->status_penasehat === 'signed' && $surat->ttd_penasehat)
                        <img src="{{ $surat->ttd_penasehat }}" class="sig-image" alt="TTD Penasehat">
                    @endif
                </div>
                <div class="sig-name">{{ $surat->nama_penasehat ?? '-' }}</div>
            </td>
            <td>
                <div>Dibuat oleh,<br><strong>Sekretaris</strong></div>
                <div class="sig-space">
                    @if($surat->status_sekretaris === 'signed' && $surat->ttd_sekretaris)
                        <img src="{{ $surat->ttd_sekretaris }}" class="sig-image" alt="TTD Sekretaris">
                    @endif
                </div>
                <div class="sig-name">{{ $surat->nama_sekretaris ?? '-' }}</div>
            </td>
            <td>
                <div>Menyetujui,<br><strong>Ketua Takmir</strong></div>
                <div class="sig-space">
                    @if($surat->status_ketua === 'signed' && $surat->ttd_ketua)
                        <img src="{{ $surat->ttd_ketua }}" class="sig-image" alt="TTD Ketua">
                    @endif
                </div>
                <div class="sig-name">{{ $surat->nama_ketua ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <script>
        // Auto trigger print dialogue on load
        window.addEventListener('load', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
