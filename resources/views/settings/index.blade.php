<!DOCTYPE html>
<html lang="en">
<head>
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
                            <h2><span>📝</span> {{ $template->key === 'spp_kuitansi' ? 'Kuitansi SPP TPQ' : 'Kuitansi Scan Koin Baginda' }}</h2>
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
                                @else
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_pemilik}')"><code>{nama_pemilik}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{kode_kaleng}')"><code>{kode_kaleng}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{nama_kaleng}')"><code>{nama_kaleng}</code></span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder('template_{{ $template->key }}', '{tanggal_ambil}')"><code>{tanggal_ambil}</code></span>
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

            // Show current tab content
            document.getElementById('tab-content-' + tabName).style.display = 'block';

            // Remove active class from all sidebar links
            document.getElementById('link-api').classList.remove('active');
            document.getElementById('link-templates').classList.remove('active');

            // Add active class to clicked link
            document.getElementById('link-' + tabName).classList.add('active');

            // Update page header title
            const headerTitle = document.getElementById('page-header-title');
            if (tabName === 'api') {
                headerTitle.textContent = 'Konfigurasi API';
            } else {
                headerTitle.textContent = 'Template WhatsApp';
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

        // Initialize active tab from query parameter on page load
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'api';
            switchTab(activeTab);
        });
    </script>
</body>
</html>
