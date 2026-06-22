<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Baginda</title>
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
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar-brand {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .menu-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            font-size: 20px;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .menu-toggle:active {
            transform: scale(0.95);
        }
        
        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        
        .navbar-menu a, .navbar-menu button {
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 5px;
            transition: background 0.3s;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
        }
        
        .navbar-menu a:hover, .navbar-menu button:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .profile-toggle {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 99px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .profile-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .profile-toggle:active {
            transform: translateY(0);
        }

        .profile-toggle .profile-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            background: white;
            color: #10b981;
            border-radius: 50%;
            font-weight: 800;
            font-size: 13px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .profile-dropdown {
            position: absolute;
            top: 52px;
            right: 0;
            width: 320px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
            display: none;
            z-index: 120;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.2s ease-out;
        }

        .profile-dropdown.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-dropdown-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 24px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
        }

        .profile-dropdown-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .profile-dropdown-avatar svg {
            width: 44px;
            height: 44px;
        }

        .profile-dropdown-name {
            font-size: 18px;
            font-weight: 700;
            color: white;
            margin: 0;
            line-height: 1.2;
        }

        .profile-dropdown-role {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 4px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 10px;
            border-radius: 20px;
        }

        .profile-dropdown-footer {
            display: flex;
            padding: 16px;
            background: #f8fafc;
            gap: 12px;
            border-top: 1px solid #edf2f7;
        }

        .profile-dropdown .btn-profile-action {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
            padding: 10px 14px !important;
            border-radius: 10px !important;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px !important;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            height: auto;
        }

        .profile-dropdown .btn-profile-action:hover {
            background: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        .password-form-collapse {
            display: none;
            background: #f8fafc;
            padding: 20px;
            border-top: 1px solid #edf2f7;
            border-bottom: 1px solid #edf2f7;
        }

        .password-form-collapse.show {
            display: block;
        }

        .password-form-collapse label {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .password-form-collapse input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            margin-bottom: 12px;
            font-size: 14px;
            background: white;
            color: #1e293b;
            transition: border-color 0.2s;
        }

        .password-form-collapse input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .profile-dropdown .password-form-collapse .save-button {
            width: 100% !important;
            padding: 12px 0 !important;
            border: none !important;
            border-radius: 8px !important;
            background: #10b981 !important;
            color: white !important;
            font-weight: 700 !important;
            cursor: pointer;
            font-size: 14px !important;
            transition: background 0.2s;
        }

        .profile-dropdown .password-form-collapse .save-button:hover {
            background: #059669 !important;
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 24px;
        }
        
        .dashboard-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            margin-bottom: 30px;
            border: 1px solid rgba(16, 185, 129, 0.08);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, #10b981, #059669);
        }
        
        .dashboard-header h2 {
            color: #0f172a;
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .user-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-top: 24px;
        }
        
        .info-card {
            background: #f8fafc;
            padding: 18px 20px;
            border-radius: 14px;
            border-left: 4px solid #10b981;
            border-top: 1px solid rgba(0,0,0,0.01);
            border-right: 1px solid rgba(0,0,0,0.01);
            border-bottom: 1px solid rgba(0,0,0,0.01);
            transition: all 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            background: #f1f5f9;
            border-left-color: #059669;
        }
        
        .info-card label {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        
        .info-card .value {
            color: #0f172a;
            font-size: 15px;
            font-weight: 600;
        }
        
        .dashboard-content {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(16, 185, 129, 0.08);
            margin-bottom: 40px;
        }
        
        .dashboard-content h3 {
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.4px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .dashboard-content h3::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: #10b981;
        }
        
        .welcome-message {
            color: #475569;
            line-height: 1.6;
            font-size: 15px;
            margin-bottom: 24px;
        }
        
        .welcome-message p {
            margin-bottom: 12px;
        }

        .alert {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert.error ul {
            margin: 0;
            padding-left: 18px;
        }

        .save-button {
            width: 100%;
            margin-top: 18px;
            padding: 12px 16px;
            border-radius: 10px;
            border: none;
            background: #10b981;
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        .save-button:hover {
            opacity: 0.95;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .menu-item {
            position: relative;
            color: white;
            padding: 24px;
            border-radius: 16px;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 190px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .menu-item:hover::before {
            opacity: 1;
        }
        
        .menu-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }
        
        .menu-item-icon {
            font-size: 30px;
            background: rgba(255, 255, 255, 0.2);
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s;
        }
        
        .menu-item:hover .menu-item-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .menu-item-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.3px;
            margin-top: 12px;
        }
        
        .menu-item-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 6px;
            line-height: 1.4;
            font-weight: 400;
            flex-grow: 1;
        }

        .menu-item-arrow {
            font-size: 13px;
            font-weight: 600;
            color: white;
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 4px;
            opacity: 0.95;
            transition: gap 0.2s;
        }

        .menu-item:hover .menu-item-arrow {
            gap: 8px;
        }

        /* Specific Gradients */
        .item-user { background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); }
        .item-koin { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .item-op { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
        .item-keu { background: linear-gradient(135deg, #10b981 0%, #047857 100%); }
        .item-tpq { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
        .item-about { background: linear-gradient(135deg, #6b7280 0%, #374151 100%); }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 12px 20px;
            }
            .navbar-brand {
                font-size: 20px;
            }
            .menu-toggle {
                display: block;
            }
            .navbar-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                width: 100%;
                flex-direction: column;
                background: #10b981;
                gap: 0;
                padding: 8px 0;
                border-top: 1px solid rgba(255,255,255,0.1);
                z-index: 99;
                box-shadow: 0 10px 15px rgba(0,0,0,0.1);
            }
            .navbar-menu.active {
                display: flex;
            }
            .navbar-menu button, .navbar-menu a {
                width: 100%;
                text-align: center;
                padding: 12px;
                border-radius: 0;
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.08);
                background: transparent;
                margin: 0;
            }
            .navbar-menu button:last-child, .navbar-menu a:last-child {
                border-bottom: none;
            }
            
            .profile-toggle {
                width: 100%;
                justify-content: center;
                border-radius: 0;
                border: none;
            }
            
            .profile-dropdown {
                position: static;
                width: auto;
                margin: 10px 16px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            }
            
            .container {
                margin: 20px auto;
                padding: 0 16px;
            }
            
            .dashboard-header {
                padding: 20px;
            }
            .dashboard-header h2 {
                font-size: 22px;
            }
            .user-info {
                grid-template-columns: 1fr;
            }
            
            .dashboard-content {
                padding: 24px;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand"><span>🕌</span> Masjid Baginda</div>
        <button type="button" class="menu-toggle" id="menuToggle">☰</button>
        <div class="navbar-menu" id="navbarMenu">
            <button type="button" id="profileToggle" class="profile-toggle">
                <span class="profile-icon">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                <span>Akun Saya</span>
                <span>▾</span>
            </button>

            <div class="profile-dropdown{{ $errors->any() || session('success') ? ' active' : '' }}" id="profileDropdown">
                <div class="profile-dropdown-header">
                    <div class="profile-dropdown-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                            <!-- Outer Hexagon -->
                            <polygon points="40,15 61.65,27.5 61.65,52.5 40,65 18.35,52.5 18.35,27.5" fill="none" stroke="#fd6585" stroke-width="2.5" stroke-linejoin="round"/>
                            <!-- Inner Lines from Center (40,40) -->
                            <line x1="40" y1="40" x2="40" y2="15" stroke="#fd6585" stroke-width="2.5" />
                            <line x1="40" y1="40" x2="40" y2="65" stroke="#fd6585" stroke-width="2.5" />
                            <line x1="40" y1="40" x2="61.65" y2="27.5" stroke="#fd6585" stroke-width="2.5" />
                            <line x1="40" y1="40" x2="18.35" y2="27.5" stroke="#fd6585" stroke-width="2.5" />
                            <line x1="40" y1="40" x2="61.65" y2="52.5" stroke="#fd6585" stroke-width="2.5" />
                            <line x1="40" y1="40" x2="18.35" y2="52.5" stroke="#fd6585" stroke-width="2.5" />
                            <!-- Vertices Nodes -->
                            <circle cx="40" cy="15" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="61.65" cy="27.5" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="61.65" cy="52.5" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="40" cy="65" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="18.35" cy="52.5" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="18.35" cy="27.5" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                            <circle cx="40" cy="40" r="4.5" fill="#fd6585" stroke="#ffffff" stroke-width="1" />
                        </svg>
                    </div>
                    <div class="profile-dropdown-name">{{ $user->name }}</div>
                    <div class="profile-dropdown-role">{{ ucfirst($hakakses->nama_hakakses) }}</div>
                </div>

                <!-- Collapsible Password Form Section -->
                <div class="password-form-collapse{{ $errors->any() || session('success') ? ' show' : '' }}" id="passwordFormCollapse">
                    @if(session('success'))
                        <div class="alert success" style="margin-bottom:12px;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert error" style="margin-bottom:12px;">
                            <ul style="margin:0; padding-left: 16px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('dashboard.password.update') }}" method="POST">
                        @csrf
                        <label for="current_password">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" required>

                        <label for="password">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" required>

                        <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>

                        <button type="submit" class="save-button">Simpan Kata Sandi</button>
                    </form>
                </div>

                <div class="profile-dropdown-footer">
                    <button type="button" class="btn-profile-action" id="togglePasswordFormBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 2px;">
                            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                        </svg>
                        <span>Ubah Password</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0; flex: 1;">
                        @csrf
                        <button type="submit" class="btn-profile-action" style="width: 100%;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="dashboard-header">
            <h2>Selamat Datang, {{ $user->name }}! 👋</h2>
            
            <div class="user-info">
                <div class="info-card">
                    <label>Email</label>
                    <div class="value">{{ $user->email }}</div>
                </div>
                <div class="info-card">
                    <label>Hak Akses</label>
                    <div class="value">{{ ucfirst($hakakses->nama_hakakses) }}</div>
                </div>
                <div class="info-card">
                    <label>Deskripsi</label>
                    <div class="value">{{ $hakakses->deskripsi }}</div>
                </div>
            </div>
        </div>
        
        <div class="dashboard-content">
            <h3>📊 Dashboard Utama</h3>
            
            <div class="welcome-message">
                <p>Anda telah berhasil login ke sistem Baginda dengan hak akses <strong>{{ ucfirst($hakakses->nama_hakakses) }}</strong>.</p>
                <p>Gunakan menu di bawah untuk mengakses berbagai fitur sistem sesuai dengan hak akses Anda.</p>
            </div>

            <div class="menu-grid">
                @if ($user->hasAccess('users'))
                    <a href="{{ route('users.index') }}" class="menu-item item-user">
                        <div class="menu-item-icon">👥</div>
                        <div class="menu-item-name">Manajemen User</div>
                        <div class="menu-item-desc">Atur data pengguna, hak akses, dan tingkat keamanan sistem secara terpusat.</div>
                        <div class="menu-item-arrow">Buka Modul ➔</div>
                    </a>
                @endif

                @if ($user->hasAccess('koin'))
                    <a href="{{ route('koin.index') }}" class="menu-item item-koin">
                        <div class="menu-item-icon">🥫</div>
                        <div class="menu-item-name">Koin Baginda</div>
                        <div class="menu-item-desc">Pencatatan sirkulasi, stok, dan distribusi Koin Baginda untuk sosial masjid.</div>
                        <div class="menu-item-arrow">Buka Modul ➔</div>
                    </a>
                @endif
                
                @if ($user->hasAccess('operasional'))
                    <a href="{{ route('operasional.dashboard') }}" class="menu-item item-op">
                        <div class="menu-item-icon">📋</div>
                        <div class="menu-item-name">Data Operasional</div>
                        <div class="menu-item-desc">Pengelolaan inventarisasi fisik, aset, dan berkas administrasi operasional.</div>
                        <div class="menu-item-arrow">Buka Modul ➔</div>
                    </a>
                @endif
                
                @if ($user->hasAccess('keuangan'))
                    <a href="{{ route('keuangan.index') }}" class="menu-item item-keu">
                        <div class="menu-item-icon">💰</div>
                        <div class="menu-item-name">Keuangan</div>
                        <div class="menu-item-desc">Pantau catatan kas masuk, pengeluaran, anggaran, serta infak & sedekah masjid.</div>
                        <div class="menu-item-arrow">Buka Modul ➔</div>
                    </a>
                @endif
                
                @if ($user->hasAccess('tpq'))
                    <a href="{{ route('tpq.dashboard') }}" class="menu-item item-tpq">
                        <div class="menu-item-icon">📚</div>
                        <div class="menu-item-name">Manajemen TPQ</div>
                        <div class="menu-item-desc">Kelola administrasi santri, data kelas, guru pengampu, absensi, serta rekap laporan.</div>
                        <div class="menu-item-arrow">Buka Modul ➔</div>
                    </a>
                @endif
                
                @if ($user->hasAccess('tentang'))
                    <a href="{{ route('settings.index') }}" class="menu-item item-about">
                        <div class="menu-item-icon">⚙️</div>
                        <div class="menu-item-name">Pengaturan Sistem</div>
                        <div class="menu-item-desc">Konfigurasi token WhatsApp Gateway Fonnte, kredensial Payment Gateway Midtrans, dan parameter sistem lainnya.</div>
                        <div class="menu-item-arrow">Buka Pengaturan ➔</div>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <script>
        const menuToggle     = document.getElementById('menuToggle');
        const navbarMenu     = document.getElementById('navbarMenu');
        const profileToggle  = document.getElementById('profileToggle');
        const profileDropdown = document.getElementById('profileDropdown');
        const togglePasswordFormBtn = document.getElementById('togglePasswordFormBtn');
        const passwordFormCollapse = document.getElementById('passwordFormCollapse');

        // Hamburger toggle (mobile only)
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                navbarMenu.classList.toggle('active');
                // Tutup profile dropdown saat menu ditutup
                if (!navbarMenu.classList.contains('active')) {
                    profileDropdown.classList.remove('active');
                }
            });
        }

        // Profile dropdown toggle
        if (profileToggle) {
            profileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
            });
        }

        // Toggle password form inside dropdown
        if (togglePasswordFormBtn && passwordFormCollapse) {
            togglePasswordFormBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                passwordFormCollapse.classList.toggle('show');
            });
        }

        // Klik di luar — tutup semua
        document.addEventListener('click', function(e) {
            if (profileDropdown && !profileDropdown.contains(e.target) && !profileToggle.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
            if (navbarMenu && !navbarMenu.contains(e.target) && menuToggle && !menuToggle.contains(e.target)) {
                navbarMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
