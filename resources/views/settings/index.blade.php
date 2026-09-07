<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ $logoFavicon }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Baginda</title>
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
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 200;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }
        .sidebar-brand {
            padding: 22px 20px 18px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sidebar-brand span {
            font-size: 22px;
        }
        .sidebar-nav {
            flex: 1;
            padding: 12px 0;
        }
        .sidebar-nav a, .sidebar-nav button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 20px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border: none;
            background: none;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-align: left;
            outline: none;
        }
        .sidebar-nav a:hover, .sidebar-nav button:hover {
            background: rgba(255,255,255,0.12);
            color: white;
        }
        .sidebar-nav a.active, .sidebar-nav button.active {
            background: rgba(255,255,255,0.18);
            color: white;
            font-weight: 600;
            border-left: 4px solid white;
        }
        .sidebar-nav .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        .sidebar-nav .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 8px 16px;
        }

        /* ── Main Content Area ── */
        .main {
            margin-left: 240px;
            flex: 1;
            padding: 40px 5%;
            min-height: 100vh;
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

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
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

        .card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(16, 185, 129, 0.08);
            margin-bottom: 24px;
            position: relative;
        }

        .card-header {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .card h2 {
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-desc {
            font-size: 13.5px;
            color: #64748b;
            margin-top: 6px;
            line-height: 1.4;
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

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .toggle-btn:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
        }

        .button-primary {
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 14.5px;
            transition: all 0.2s ease;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .button-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);
        }

        .button-secondary {
            padding: 12px 24px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            color: #475569;
            font-weight: 700;
            cursor: pointer;
            font-size: 14.5px;
            transition: all 0.2s ease;
            text-decoration: none;
            background: #f1f5f9;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .button-secondary:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .placeholder-tag {
            background: #eef7f4;
            border: 1px solid #d1fae5;
            color: #065f46;
            font-size: 11.5px;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .placeholder-tag:hover {
            background: #d1fae5;
            transform: translateY(-1px);
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
            flex-shrink: 0;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ef4444;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        input:checked + .slider {
            background-color: #10b981;
        }
        input:checked + .slider:before {
            transform: translateX(24px);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            }
            .sidebar-brand {
                padding: 16px;
            }
            .sidebar-nav {
                display: flex;
                padding: 4px;
                overflow-x: auto;
            }
            .sidebar-nav a, .sidebar-nav button {
                width: auto;
                white-space: nowrap;
                padding: 10px 16px;
            }
            .sidebar-nav a.active, .sidebar-nav button.active {
                border-left: none;
                border-bottom: 3px solid white;
            }
            .sidebar-nav .divider {
                display: none;
            }
            .sidebar-footer {
                display: none;
            }
            .main {
                margin-left: 0;
                padding: 24px 16px;
            }
            .form-actions {
                flex-direction: column-reverse;
            }
            .button-primary,
            .button-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>⚙️</span> Pengaturan
        </div>
        <nav class="sidebar-nav">
            <button type="button" id="link-api" class="active" onclick="switchTab('api')">
                <span class="nav-icon">🔑</span> Konfigurasi API
            </button>
            <button type="button" id="link-templates" onclick="switchTab('templates')">
                <span class="nav-icon">📝</span> Template WhatsApp
            </button>
            <button type="button" id="link-login" onclick="switchTab('login')">
                <span class="nav-icon">🖼️</span> Logo & Tampilan
            </button>
            <button type="button" id="link-wagroups" onclick="switchTab('wagroups')">
                <span class="nav-icon">👥</span> Master Grup WA
            </button>
            <div class="divider"></div>
            <a href="{{ route('dashboard') }}">
                <span class="nav-icon">⬅️</span> Dashboard Utama
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.12); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; transition: background 0.2s;">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main">
        <div class="page-title">
            <h1 id="page-header-title">Konfigurasi API</h1>
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

        <!-- Tab 1: API Configuration -->
        <div id="tab-content-api">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                
                <!-- Card: WhatsApp Fonnte -->
                <div class="card">
                    <div class="card-header">
                        <h2><span>📲</span> WhatsApp Gateway Fonnte</h2>
                        <div class="card-desc">Konfigurasi token Fonnte untuk otomatisasi pengiriman broadcast pesan kuitansi SPP TPQ dan Scan Koin Baginda.</div>
                    </div>

                    <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                        <div>
                            <label style="margin-bottom: 4px; font-size: 15px; display: block; color: #334155; font-weight: 600;">Status WhatsApp Gateway</label>
                            <p style="font-size: 12.5px; color: #64748b; margin: 0;">Aktifkan atau nonaktifkan fitur pengiriman pesan WhatsApp secara keseluruhan.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="whatsapp_status" value="1" {{ old('whatsapp_status', $setting->whatsapp_status ?? 1) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="fonnte_token">Token API Fonnte</label>
                        <div class="input-group">
                            <input type="password" id="fonnte_token" name="fonnte_token" value="{{ old('fonnte_token', $setting->fonnte_token) }}" placeholder="Masukkan Token API Fonnte Anda">
                            <button type="button" class="toggle-btn" onclick="toggleVisibility('fonnte_token')">Tampilkan</button>
                        </div>
                        <p style="font-size:12px; color:#64748b; margin-top:6px;">Jika dikosongkan, sistem akan otomatis menggunakan fallback token yang disetel di file konfigurasi server (`.env`).</p>
                    </div>
                </div>

                <!-- Card: Payment Gateway Midtrans -->
                <div class="card">
                    <div class="card-header">
                        <h2><span>💳</span> Payment Gateway Midtrans</h2>
                        <div class="card-desc">Konfigurasi Client ID, Server Key, dan Environment Mode untuk memproses pembayaran online.</div>
                    </div>

                    <div class="form-group">
                        <label for="midtrans_client_id">Midtrans Client ID</label>
                        <input type="text" id="midtrans_client_id" name="midtrans_client_id" value="{{ old('midtrans_client_id', $setting->midtrans_client_id) }}" placeholder="Masukkan Midtrans Client ID">
                    </div>

                    <div class="form-group">
                        <label for="midtrans_server_key">Midtrans Server Key</label>
                        <div class="input-group">
                            <input type="password" id="midtrans_server_key" name="midtrans_server_key" value="{{ old('midtrans_server_key', $setting->midtrans_server_key) }}" placeholder="Masukkan Midtrans Server Key">
                            <button type="button" class="toggle-btn" onclick="toggleVisibility('midtrans_server_key')">Tampilkan</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="midtrans_environment">Midtrans Environment Mode</label>
                        <select id="midtrans_environment" name="midtrans_environment" required>
                            <option value="sandbox" {{ old('midtrans_environment', $setting->midtrans_environment) === 'sandbox' ? 'selected' : '' }}>Sandbox (Development/Testing)</option>
                            <option value="production" {{ old('midtrans_environment', $setting->midtrans_environment) === 'production' ? 'selected' : '' }}>Production (Live/Asli)</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="button-secondary">Kembali ke Dashboard</a>
                    <button type="submit" class="button-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>

        <!-- Tab 2: WhatsApp Templates Editor -->
        <div id="tab-content-templates" style="display: none;">
            <form action="{{ route('settings.templates.update') }}" method="POST">
                @csrf

                @foreach($templates as $template)
                    <div class="card">
                        <div class="card-header">
                            <h2><span>📝</span> 
                                @if($template->key === 'spp_kuitansi')
                                    Kuitansi SPP TPQ
                                @elseif($template->key === 'koin_scan')
                                    Kuitansi Scan Koin Baginda
                                @elseif($template->key === 'tpq_absensi')
                                    Notifikasi Absensi TPQ
                                @elseif($template->key === 'tpq_prestasi_sorogan')
                                    Notifikasi Prestasi Sorogan
                                @elseif($template->key === 'tpq_prestasi_hafalan')
                                    Notifikasi Prestasi Hafalan
                                @else
                                    {{ $template->key }}
                                @endif
                            </h2>
                            <div class="card-desc">Edit format pesan WhatsApp yang dikirim otomatis untuk modul ini.</div>
                        </div>

                        <input type="hidden" name="templates[{{ $loop->index }}][key]" value="{{ $template->key }}">

                        <div class="form-group">
                            <label for="template_{{ $template->key }}">Isi Pesan WhatsApp</label>
                            <textarea id="template_{{ $template->key }}" name="templates[{{ $loop->index }}][template]" rows="8" style="width:100%; padding:12px; border-radius:10px; border:1px solid #cbd5e1; font-family: 'Courier New', Courier, monospace; font-size:14px; line-height:1.5;" required>{{ old('templates.'.$loop->index.'.template', $template->template) }}</textarea>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; margin-top: 12px;">
                            <strong style="font-size:12.5px; color:#334155; display:block; margin-bottom:8px;">Placeholder Variabel (Klik untuk menyisipkan):</strong>
                            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                                @if($template->key === 'spp_kuitansi')
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_santri}')"><code>{nama_santri}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{bulan}')"><code>{bulan}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tahun}')"><code>{tahun}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{jumlah}')"><code>{jumlah}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal_bayar}')"><code>{tanggal_bayar}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_wali}')"><code>{nama_wali}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{penerima}')"><code>{penerima}</code></span>
                                @elseif($template->key === 'koin_scan')
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_pemilik}')"><code>{nama_pemilik}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{kode_kaleng}')"><code>{kode_kaleng}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_kaleng}')"><code>{nama_kaleng}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal_ambil}')"><code>{tanggal_ambil}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_petugas}')"><code>{nama_petugas}</code></span>
                                @elseif($template->key === 'tpq_absensi')
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_santri}')"><code>{nama_santri}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal}')"><code>{tanggal}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{status}')"><code>{status}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{keterangan}')"><code>{keterangan}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_wali}')"><code>{nama_wali}</code></span>
                                @elseif($template->key === 'tpq_prestasi_sorogan')
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_santri}')"><code>{nama_santri}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal}')"><code>{tanggal}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{materi_detail}')"><code>{materi_detail}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{keterangan}')"><code>{keterangan}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_petugas}')"><code>{nama_petugas}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_wali}')"><code>{nama_wali}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{link_prestasi}')"><code>{link_prestasi}</code></span>
                                @elseif($template->key === 'tpq_prestasi_hafalan')
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_santri}')"><code>{nama_santri}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal}')"><code>{tanggal}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_hafalan}')"><code>{nama_hafalan}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{kategori}')"><code>{kategori}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{keterangan}')"><code>{keterangan}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_petugas}')"><code>{nama_petugas}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_wali}')"><code>{nama_wali}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{link_prestasi}')"><code>{link_prestasi}</code></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="button-secondary">Kembali ke Dashboard</a>
                    <button type="submit" class="button-primary">Simpan Template</button>
                </div>
            </form>
        </div>

        <!-- Tab 3: Login Page Styling -->
        <div id="tab-content-login" style="display: none;">
            <!-- Card 1: Logo Aplikasi -->
            <div class="card">
                <div class="card-header">
                    <h2><span>🕌</span> Logo Aplikasi</h2>
                    <div class="card-desc">Ganti logo Masjid Baginda yang muncul di header Dashboard dan Halaman Login.</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;">
                    <div>
                        <strong style="display: block; font-size: 14px; color: #475569; margin-bottom: 10px;">Preview Logo Saat Ini:</strong>
                        <div style="border-radius: 12px; overflow: hidden; border: 2px solid #cbd5e1; height: 160px; background: #f8fafc; display: flex; align-items: center; justify-content: center; position: relative; padding: 15px;">
                            @if($setting->logo)
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            @else
                                <img src="{{ asset('images/image.png') }}" alt="Default Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            @endif
                            <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(15, 23, 42, 0.75); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                {{ $setting->logo ? 'Logo Kustom' : 'Logo Default' }}
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; justify-content: center;">
                        <form action="{{ route('settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="logo" style="font-weight:600; display:block; margin-bottom:8px;">Pilih Logo Baru</label>
                                <input type="file" id="logo" name="logo" accept="image/*" required style="padding: 10px; border: 1px dashed #cbd5e1; width: 100%; border-radius: 10px; background: #f8fafc; font-family: inherit;">
                                <p style="font-size: 12px; color: #64748b; margin-top: 6px;">Format yang didukung: PNG, JPG, JPEG, SVG, WEBP (Maksimal 2MB).</p>
                            </div>
                            <button type="submit" class="button-primary" style="width:100%; padding:14px; font-weight:700;">Unggah Logo Baru</button>
                        </form>

                        @if($setting->logo)
                            <form action="{{ route('settings.logo.reset') }}" method="POST" style="margin-top: 12px;">
                                @csrf
                                <button type="submit" class="button-secondary" style="width:100%; padding:14px; font-weight:700; background:#dc2626; color:white; border:none;" onclick="return confirm('Apakah Anda yakin ingin mengembalikan logo ke default?')">Reset ke Logo Default</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card 2: Desain Background Halaman Login -->
            <div class="card">
                <div class="card-header">
                    <h2><span>🖼️</span> Desain Background Halaman Login</h2>
                    <div class="card-desc">Ganti foto background masjid pada halaman login atau kembalikan ke background default bawaan sistem.</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;">
                    <div>
                        <strong style="display: block; font-size: 14px; color: #475569; margin-bottom: 10px;">Preview Background Saat Ini:</strong>
                        <div style="border-radius: 12px; overflow: hidden; border: 2px solid #cbd5e1; height: 220px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; position: relative;">
                            @if($setting->foto_masjid)
                                <img src="{{ asset('storage/' . $setting->foto_masjid) }}" alt="Login Background" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default_mosque_bg.png') }}" alt="Default Background" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                            <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(15, 23, 42, 0.75); color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                {{ $setting->foto_masjid ? 'Gambar Kustom' : 'Gambar Default' }}
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; justify-content: center;">
                        <form action="{{ route('settings.login-bg.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="foto_masjid" style="font-weight:600; display:block; margin-bottom:8px;">Pilih Foto Masjid Baru</label>
                                <input type="file" id="foto_masjid" name="foto_masjid" accept="image/*" required style="padding: 10px; border: 1px dashed #cbd5e1; width: 100%; border-radius: 10px; background: #f8fafc; font-family: inherit;">
                                <p style="font-size: 12px; color: #64748b; margin-top: 6px;">Format yang didukung: JPG, JPEG, PNG, WEBP (Maksimal 5MB).</p>
                            </div>
                            <button type="submit" class="button-primary" style="width:100%; padding:14px; font-weight:700;">Unggah Background Baru</button>
                        </form>

                        @if($setting->foto_masjid)
                            <form action="{{ route('settings.login-bg.reset') }}" method="POST" style="margin-top: 12px;">
                                @csrf
                                <button type="submit" class="button-secondary" style="width:100%; padding:14px; font-weight:700; background:#dc2626; color:white; border:none;" onclick="return confirm('Apakah Anda yakin ingin mengembalikan background ke default?')">Reset ke Background Default</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card 3: Gambar Pengumuman Slideshow -->
            <div class="card" style="margin-top: 24px;">
                <div class="card-header">
                    <h2><span>📢</span> Slideshow Pengumuman Dashboard</h2>
                    <div class="card-desc">Unggah gambar pengumuman atau pamflet kegiatan masjid yang akan ditampilkan pada slideshow di halaman utama.</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px;">
                    <!-- Left: Upload Form -->
                    <div>
                        <form action="{{ route('settings.pengumuman.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="margin-bottom: 16px;">
                                <label for="image" style="font-weight:600; display:block; margin-bottom:8px;">Pilih Gambar Pengumuman</label>
                                <input type="file" id="image" name="image" accept="image/*" required style="padding: 10px; border: 1px dashed #cbd5e1; width: 100%; border-radius: 10px; background: #f8fafc; font-family: inherit;">
                                <p style="font-size: 12px; color: #64748b; margin-top: 6px;">Rekomendasi rasio 16:9. Format: JPG, JPEG, PNG, WEBP (Maksimal 5MB).</p>
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="title" style="font-weight:600; display:block; margin-bottom:8px;">Judul / Keterangan Singkat (Opsional)</label>
                                <input type="text" id="title" name="title" placeholder="Contoh: Kajian Rutin Ahad Pagi" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: inherit;">
                            </div>
                            <button type="submit" class="button-primary" style="width:100%; padding:14px; font-weight:700;">Unggah Pengumuman</button>
                        </form>
                    </div>

                    <!-- Right: Current Announcements List -->
                    <div>
                        <strong style="display: block; font-size: 14px; color: #475569; margin-bottom: 12px;">Daftar Pengumuman Aktif:</strong>
                        
                        @if($pengumumanList->isEmpty())
                            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 24px; text-align: center; color: #64748b; font-size: 13.5px;">
                                Belum ada gambar pengumuman yang diunggah. Slideshow akan menggunakan gambar default.
                            </div>
                        @else
                            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 320px; overflow-y: auto; padding-right: 5px;">
                                @foreach($pengumumanList as $item)
                                    <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 12px; gap: 12px;">
                                        <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
                                            <div style="width: 80px; height: 45px; border-radius: 6px; overflow: hidden; background: #e2e8f0; flex-shrink: 0; border: 1px solid #cbd5e1;">
                                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div style="min-width: 0; flex: 1;">
                                                <div style="font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->title ?? 'Pengumuman #' . $item->id }}
                                                </div>
                                                <div style="font-size: 11px; color: #64748b;">
                                                    Diunggah: {{ $item->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('settings.pengumuman.delete', $item->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 16px; padding: 6px; border-radius: 8px; transition: background 0.2s;" onclick="return confirm('Hapus gambar pengumuman ini?')" title="Hapus Pengumuman">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Master WhatsApp Groups -->
        <div id="tab-content-wagroups" style="display: none;">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">
                <!-- Left Column: Fonnte Sync & Manual Add -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Fetch Live Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2><span>📲</span> Tarik dari Fonnte</h2>
                            <div class="card-desc">Ambil daftar grup WhatsApp secara live dari Fonnte untuk langsung disimpan.</div>
                        </div>
                        <div style="margin-top: 15px;">
                            <button type="button" class="button-primary" style="width: 100%; background: #0f766e; color: white;" onclick="syncFonnteGroups()">🔍 Ambil Grup Live</button>
                            
                            <div id="fonnte-sync-container" style="margin-top: 15px; display: none; max-height: 250px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; background: #f8fafc;">
                                <div id="fonnte-sync-list" style="display: flex; flex-direction: column; gap: 8px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Group Card (Manual) -->
                    <div class="card">
                        <div class="card-header">
                            <h2><span>➕</span> Tambah Manual</h2>
                            <div class="card-desc">Masukkan ID grup secara manual jika Anda memilikinya.</div>
                        </div>
                        <form action="{{ route('settings.wa-groups.store') }}" method="POST" style="margin-top: 15px;">
                            @csrf
                            <div class="form-group">
                                <label for="group_name">Nama Grup</label>
                                <input type="text" id="group_name" name="group_name" placeholder="Contoh: Keluarga Takmir" required>
                            </div>
                            <div class="form-group">
                                <label for="group_id">ID Grup WhatsApp</label>
                                <input type="text" id="group_id" name="group_id" placeholder="Contoh: 120363412998841695@g.us" required>
                                <p style="font-size: 11px; color: #64748b; margin-top: 4px;">ID Grup Fonnte biasanya diakhiri dengan `@g.us`</p>
                            </div>
                            <button type="submit" class="button-primary" style="width: 100%; margin-top: 10px;">Simpan Grup</button>
                        </form>
                    </div>
                </div>

                <!-- Group List Card -->
                <div class="card">
                    <div class="card-header">
                        <h2><span>📋</span> Daftar Grup WhatsApp</h2>
                        <div class="card-desc">Master grup WhatsApp takmir yang tersimpan di sistem.</div>
                    </div>
                    <div style="margin-top: 15px;">
                        @if($whatsappGroups->isEmpty())
                            <div style="text-align: center; color: #64748b; padding: 30px 0;">Belum ada grup WhatsApp yang didaftarkan.</div>
                        @else
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                                        <th style="padding: 10px; font-weight: bold; color: #0f4d36;">Nama Grup</th>
                                        <th style="padding: 10px; font-weight: bold; color: #0f4d36;">ID Grup (Fonnte)</th>
                                        <th style="padding: 10px; font-weight: bold; color: #0f4d36; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($whatsappGroups as $group)
                                        <tr style="border-bottom: 1px solid #e2e8f0;">
                                            <td style="padding: 10px; font-weight: bold; color: #334155;">{{ $group->group_name }}</td>
                                            <td style="padding: 10px; color: #64748b; font-family: monospace;">{{ $group->group_id }}</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <form action="{{ route('settings.wa-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus grup ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: #ef4444; color: white; border: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleVisibility(inputId) {
            const input = document.getElementById(inputId);
            const btn = input.nextElementSibling;
            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "Sembunyikan";
            } else {
                input.type = "password";
                btn.textContent = "Tampilkan";
            }
        }

        function switchTab(tabName) {
            // Hide all tab contents
            document.getElementById('tab-content-api').style.display = 'none';
            document.getElementById('tab-content-templates').style.display = 'none';
            document.getElementById('tab-content-login').style.display = 'none';
            document.getElementById('tab-content-wagroups').style.display = 'none';

            // Show current tab content
            document.getElementById('tab-content-' + tabName).style.display = 'block';

            // Remove active class from all sidebar links
            document.getElementById('link-api').classList.remove('active');
            document.getElementById('link-templates').classList.remove('active');
            document.getElementById('link-login').classList.remove('active');
            document.getElementById('link-wagroups').classList.remove('active');

            // Add active class to clicked link
            document.getElementById('link-' + tabName).classList.add('active');

            // Update page header title
            const headerTitle = document.getElementById('page-header-title');
            if (tabName === 'api') {
                headerTitle.textContent = 'Konfigurasi API';
            } else if (tabName === 'templates') {
                headerTitle.textContent = 'Template WhatsApp';
            } else if (tabName === 'wagroups') {
                headerTitle.textContent = 'Master Grup WhatsApp';
            } else {
                headerTitle.textContent = 'Logo & Tampilan';
            }

            // Save active tab in URL query param without full page reload
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({}, '', url);
        }

        function insertPlaceholder(textareaId, placeholder) {
            const textarea = document.getElementById(textareaId);
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const before = text.substring(0, start);
            const after = text.substring(end, text.length);
            textarea.value = before + placeholder + after;
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
        }

        function syncFonnteGroups() {
            const container = document.getElementById('fonnte-sync-container');
            const list = document.getElementById('fonnte-sync-list');
            
            container.style.display = 'block';
            list.innerHTML = '<div style="font-size:12px; color:#64748b; text-align:center; padding:10px 0;">⏳ Menghubungkan ke Fonnte...</div>';

            const url = "{{ route('operasional.broadcast.wa-groups') }}";

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        list.innerHTML = '';
                        
                        let groups = [];
                        if (Array.isArray(data.groups)) {
                            groups = data.groups;
                        } else if (data.groups && typeof data.groups === 'object') {
                            let rawGroups = data.groups;
                            if (typeof rawGroups === 'string') {
                                try { rawGroups = JSON.parse(rawGroups); } catch(e) {}
                            }
                            if (rawGroups && Array.isArray(rawGroups.data)) {
                                groups = rawGroups.data;
                            } else if (rawGroups && Array.isArray(rawGroups)) {
                                groups = rawGroups;
                            }
                        }

                        if (groups.length === 0) {
                            list.innerHTML = '<div style="font-size:12px; color:#ef4444; text-align:center; padding:10px 0;">⚠️ Tidak ada grup ditemukan. Pastikan HP aktif dan jalankan /fetch-group.</div>';
                            return;
                        }

                        groups.forEach(g => {
                            const gId = g.id || g.jid || '';
                            const gName = g.name || g.subject || 'Grup Tanpa Nama';

                            if (!gId) return;

                            const item = document.createElement('div');
                            item.style.display = 'flex';
                            item.style.justifyContent = 'space-between';
                            item.style.alignItems = 'center';
                            item.style.padding = '8px';
                            item.style.background = 'white';
                            item.style.border = '1px solid #cbd5e1';
                            item.style.borderRadius = '6px';
                            item.style.fontSize = '12px';
                            
                            item.innerHTML = `
                                <div style="flex:1; padding-right:10px; text-align:left;">
                                    <strong style="color:#0f4d36;">${gName}</strong>
                                    <div style="font-size:10px; color:#64748b; font-family:monospace; word-break:break-all;">${gId}</div>
                                </div>
                                <form action="{{ route('settings.wa-groups.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="group_name" value="${gName}">
                                    <input type="hidden" name="group_id" value="${gId}">
                                    <button type="submit" class="button-primary" style="font-size:10px; padding:4px 8px; border-radius:4px; background:#059669; border:none; color:white; cursor:pointer; font-weight:bold;">📥 Simpan</button>
                                </form>
                            `;
                            list.appendChild(item);
                        });
                    } else {
                        list.innerHTML = `<div style="font-size:12px; color:#ef4444; text-align:center; padding:10px 0;">❌ ${data.message || 'Gagal memuat grup.'}</div>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    list.innerHTML = '<div style="font-size:12px; color:#ef4444; text-align:center; padding:10px 0;">❌ Gagal menghubungi API atau Token Fonnte belum disetel.</div>';
                });
        }

        // Initialize active tab from query parameter on page load
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'api';
            switchTab(activeTab);
        });
    </script>
</body>
</html>
