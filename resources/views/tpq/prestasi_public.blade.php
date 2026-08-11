<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Prestasi Santri - {{ $santri->nama_santri }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0fdf4; color: #1e3a2f; padding: 20px 10px; }

        .container { max-width: 800px; margin: 0 auto; }
        
        /* Header Card */
        .card-header { background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; border-radius: 16px; padding: 24px; box-shadow: 0 10px 25px -5px rgba(4,120,87,0.15); margin-bottom: 24px; position: relative; overflow: hidden; }
        .card-header::before { content: ""; position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; border-radius: 50%; background: rgba(255, 255, 255, 0.08); }
        .card-header h1 { font-size: 22px; font-weight: 800; margin-bottom: 4px; letter-spacing: -0.5px; }
        .card-header p { font-size: 13.5px; opacity: 0.9; }

        /* Profile details grid */
        .profile-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.15); padding-top: 16px; }
        .profile-item { display: flex; flex-direction: column; gap: 4px; }
        .profile-item span { font-size: 11px; text-transform: uppercase; opacity: 0.75; font-weight: 700; letter-spacing: 0.5px; }
        .profile-item strong { font-size: 14.5px; font-weight: 600; }

        /* Main Section Card */
        .card-content { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 20px rgba(4,120,87,0.06); border: 1px solid #e6f4ed; }

        /* Tabs Navigation */
        .tabs-nav { display: flex; border-bottom: 2px solid #e6f4ed; margin-bottom: 20px; gap: 10px; }
        .tab-btn { background: none; border: none; padding: 12px 16px; font-size: 14.5px; font-weight: 700; color: #6b7280; cursor: pointer; transition: all 0.2s; position: relative; outline: none; }
        .tab-btn:hover { color: #059669; }
        .tab-btn.active { color: #059669; }
        .tab-btn.active::after { content: ""; position: absolute; bottom: -2px; left: 0; right: 0; height: 2px; background: #059669; }

        /* Tab Content panels */
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* History Timeline/Table */
        .table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            display: block;
        }
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        th, td { padding: 14px 10px; text-align: left; font-size: 13.5px; border-bottom: 1px solid #f0fdf4; color: #1e3a2f; }
        .table-wrapper th, .table-wrapper td { white-space: nowrap; }
        th { background: #f0fdf4; font-weight: 700; color: #0f4d36; }
        tr:hover { background: #fafefe; }

        /* Badges */
        .badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-lanjut { background: #dcfce7; color: #15803d; }
        .badge-ulang { background: #fee2e2; color: #b91c1c; }

        /* Footer */
        .footer { text-align: center; margin-top: 30px; font-size: 12.5px; color: #869e96; }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header Info -->
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 16px;">
                @php
                    $setting = \App\Models\Setting::first();
                    $logoUrl = $setting && $setting->logo ? asset('storage/' . $setting->logo) : null;
                @endphp
                @if($logoUrl)
                    <div style="flex: 0 0 60px; background: white; padding: 6px; border-radius: 12px; display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <img src="{{ $logoUrl }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                @endif
                <div style="flex: 1;">
                    <h1>Kartu Kontrol Prestasi Santri</h1>
                    <p>TPQ Masjid Baginda - Cerdas, Berprestasi, Berakhlaqul Karimah</p>
                </div>
            </div>
            
            <div class="profile-grid">
                <div class="profile-item">
                    <span>Nama Santri</span>
                    <strong>{{ $santri->nama_santri }}</strong>
                </div>
                <div class="profile-item">
                    <span>NIS</span>
                    <strong>{{ $santri->nis }}</strong>
                </div>
                <div class="profile-item">
                    <span>Kelas</span>
                    <strong>{{ $santri->kelas?->nama_kelas ?? '-' }}@if($santri->kelas && $santri->kelas->gurus->isNotEmpty()) (Pengampu: {{ $santri->kelas->gurus->pluck('nama_guru')->implode(', ') }})@endif</strong>
                </div>
                <div class="profile-item">
                    <span>Status Saat Ini</span>
                    <strong>{{ $achSummary }}</strong>
                </div>
            </div>
        </div>

        <!-- Progress History Tabs -->
        <div class="card-content">
            <div class="tabs-nav">
                <button class="tab-btn active" onclick="switchTab(event, 'sorogan-tab')">📖 Riwayat Sorogan</button>
                <button class="tab-btn" onclick="switchTab(event, 'hafalan-tab')">🧠 Riwayat Hafalan</button>
            </div>

            <!-- TAB 1: SOROGAN -->
            <div id="sorogan-tab" class="tab-pane active">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Materi</th>
                                <th>Detail Progress</th>
                                <th>Hasil</th>
                                <th>Catatan</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sorogan as $item)
                                <tr>
                                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                                    <td><span style="text-transform: capitalize; font-weight:600;">{{ str_replace('_', ' ', $item->materi) }}</span></td>
                                    <td>
                                        @if($item->materi === 'iqro')
                                            Jilid {{ $item->iqro_jilid }} Halaman {{ $item->iqro_halaman }}
                                        @elseif($item->materi === 'alquran')
                                            Surah {{ $item->alquran_surah }} Ayat {{ $item->alquran_ayat }}
                                        @else
                                            Surah {{ $item->juz_amma_surah }} Ayat {{ $item->juz_amma_ayat }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->keterangan === 'lanjut')
                                            <span class="badge badge-lanjut">Lanjut</span>
                                        @else
                                            <span class="badge badge-ulang">Ulang</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                    <td>{{ $item->guru?->nama_guru ?? ($item->user?->name ?? 'Ustadz/Ustadzah') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color:#869e96; padding: 30px 0;">Belum ada riwayat sorogan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: HAFALAN -->
            <div id="hafalan-tab" class="tab-pane">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Materi Hafalan</th>
                                <th>Hasil</th>
                                <th>Catatan</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hafalan as $item)
                                <tr>
                                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                                    <td>
                                        <span style="font-weight:600;">
                                            {{ $item->masterHafalan?->kategori === 'surah_pendek' ? 'Surah Pendek' : 'Doa Harian' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $item->masterHafalan?->nama ?? '-' }}</strong></td>
                                    <td>
                                        @if($item->keterangan === 'lanjut')
                                            <span class="badge badge-lanjut">Lanjut</span>
                                        @else
                                            <span class="badge badge-ulang">Ulang</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->catatan ?? '-' }}</td>
                                    <td>{{ $item->guru?->nama_guru ?? ($item->user?->name ?? 'Ustadz/Ustadzah') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color:#869e96; padding: 30px 0;">Belum ada riwayat hafalan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} TPQ Masjid Baginda. Hak Cipta Dilindungi.</p>
        </div>
    </div>

    <script>
        function switchTab(e, tabId) {
            // Remove active classes
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

            // Set current active
            e.currentTarget.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</body>
</html>
