<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConnectPay - Payment System</title>
    <meta name="description" content="ConnectPay - Solusi Pembayaran Internet Terpercaya">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --primary-subtle: #eef2ff;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --success: #10b981;
            --success-subtle: #d1fae5;
            --danger: #ef4444;
            --danger-subtle: #fee2e2;
            --warning: #f59e0b;
            --warning-subtle: #fef3c7;
            --surface: #ffffff;
            --surface-hover: #f8fafc;
            --bg: #f1f5f9;
            --bg-alt: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.05);
            --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.15);
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
            --gradient-accent: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            --gradient-warm: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-2xl: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bg-alt); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* ========== NAVBAR ========== */
        .cp-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: var(--transition);
        }

        .cp-navbar.scrolled {
            box-shadow: var(--shadow-md);
            background: rgba(255, 255, 255, 0.95);
        }

        .cp-navbar .container {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .cp-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .cp-brand:hover {
            transform: scale(1.02);
        }

        .cp-brand-icon {
            width: 36px;
            height: 36px;
            background: var(--gradient-primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .cp-brand span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cp-brand em {
            font-style: normal;
            color: var(--accent);
            -webkit-text-fill-color: var(--accent);
        }

        /* Nav Links */
        .cp-nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 14px !important;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }

        .cp-nav-link:hover {
            color: var(--primary) !important;
            background-color: var(--primary-subtle);
        }

        .cp-nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-subtle);
            font-weight: 600;
        }

        .cp-nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        .cp-nav-link i {
            font-size: 1rem;
        }

        /* User Dropdown */
        .cp-user-btn {
            background: var(--primary-subtle);
            border: 1.5px solid rgba(99, 102, 241, 0.15);
            color: var(--primary-dark) !important;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 7px 16px;
            border-radius: var(--radius-lg);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cp-user-btn:hover {
            background: var(--primary);
            color: white !important;
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transform: translateY(-1px);
        }

        .cp-user-avatar {
            width: 28px;
            height: 28px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .cp-dropdown {
            border: none;
            box-shadow: var(--shadow-xl);
            border-radius: var(--radius-lg);
            padding: 8px;
            min-width: 220px;
            animation: dropdownFadeIn 0.2s ease;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cp-dropdown .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .cp-dropdown .dropdown-item:hover {
            background: var(--primary-subtle);
            color: var(--primary);
        }

        .cp-dropdown .dropdown-item.text-danger:hover {
            background: var(--danger-subtle);
            color: var(--danger);
        }

        /* ========== MAIN CONTENT ========== */
        .cp-main {
            flex: 1;
            padding: 32px 0;
        }

        /* ========== CARDS ========== */
        .cp-card {
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px;
            transition: var(--transition);
        }

        .cp-card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-custom {
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px;
            transition: var(--transition);
        }

        .card-custom:hover {
            box-shadow: var(--shadow-md);
        }

        /* ========== STAT CARDS ========== */
        .cp-stat-card {
            border-radius: var(--radius-xl);
            padding: 24px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            border: none;
        }

        .cp-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .cp-stat-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .cp-stat-card::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: -20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .cp-stat-card.primary { background: var(--gradient-primary); }
        .cp-stat-card.success { background: var(--gradient-success); }
        .cp-stat-card.danger { background: var(--gradient-danger); }
        .cp-stat-card.accent { background: var(--gradient-accent); }
        .cp-stat-card.warm { background: var(--gradient-warm); }

        .cp-stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .cp-stat-label {
            font-size: 0.8rem;
            font-weight: 500;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cp-stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* ========== BUTTONS ========== */
        .btn-connect {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            padding: 10px 24px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-connect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: 0.5s;
        }

        .btn-connect:hover::before {
            left: 100%;
        }

        .btn-connect:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
        }

        .btn-connect:active {
            transform: translateY(0);
        }

        /* ========== TABLES ========== */
        .table {
            --bs-table-bg: transparent;
        }

        .table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
            padding: 14px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .table-hover tbody tr {
            transition: var(--transition);
        }

        .table-hover tbody tr:hover {
            background-color: var(--primary-subtle);
        }

        /* ========== FORMS ========== */
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: var(--transition);
            background-color: var(--surface);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        /* ========== BADGES ========== */
        .cp-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 50px;
            letter-spacing: 0.3px;
        }

        .cp-badge.success {
            background: var(--success-subtle);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .cp-badge.danger {
            background: var(--danger-subtle);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .cp-badge.info {
            background: #e0f2fe;
            color: #0284c7;
            border: 1px solid rgba(2, 132, 199, 0.2);
        }

        /* ========== ALERTS ========== */
        .cp-alert {
            border: none;
            border-radius: var(--radius-md);
            padding: 16px 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cp-alert.success {
            background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
            color: #065f46;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }

        .cp-alert.error {
            background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
            color: #991b1b;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
        }

        /* ========== MODALS ========== */
        .modal-content {
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 16px 24px;
        }

        /* ========== PAGINATION ========== */
        .pagination {
            gap: 4px;
        }

        .page-link {
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 8px 14px;
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--primary-subtle);
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--gradient-primary);
            border-color: transparent;
        }

        /* ========== FOOTER ========== */
        .cp-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 24px 0;
            margin-top: auto;
        }

        .cp-footer-text {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .cp-footer-badge {
            background: var(--primary-subtle);
            color: var(--primary);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            letter-spacing: 0.5px;
        }

        /* ========== PAGE HEADER ========== */
        .cp-page-header {
            margin-bottom: 28px;
        }

        .cp-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .cp-page-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            .cp-navbar .container {
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .cp-nav-link.active::after {
                display: none;
            }

            .navbar-collapse {
                background: var(--surface);
                border-radius: var(--radius-lg);
                padding: 16px;
                margin-top: 12px;
                border: 1px solid var(--border);
                box-shadow: var(--shadow-lg);
            }

            .cp-main {
                padding: 20px 0;
            }
        }

        @media (max-width: 767.98px) {
            .cp-page-title {
                font-size: 1.25rem;
            }

            .cp-stat-value {
                font-size: 1.5rem;
            }

            .cp-card, .card-custom {
                padding: 20px;
                border-radius: var(--radius-lg);
            }
        }

        /* ========== EMPTY STATE ========== */
        .cp-empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        .cp-empty-state i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 16px;
            display: block;
        }

        .cp-empty-state p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ========== UTILITY ========== */
        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-primary { background: var(--gradient-primary) !important; }
        .bg-gradient-success { background: var(--gradient-success) !important; }
        .bg-gradient-danger { background: var(--gradient-danger) !important; }
        .bg-gradient-accent { background: var(--gradient-accent) !important; }
    </style>
</head>
<body>

    <nav class="cp-navbar navbar navbar-expand-lg">
        <div class="container">
            <a class="cp-brand" href="/">
                <div class="cp-brand-icon">
                    <i class="bi bi-broadcast"></i>
                </div>
                <span>Connect<em>Pay</em></span>
            </a>
            
            @auth
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Request::is('admin/pelanggan*') ? 'active' : '' }}" href="/admin/pelanggan">
                                <i class="bi bi-people-fill me-1"></i> Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Request::is('admin/pakets*') ? 'active' : '' }}" href="{{ route('pakets.index') }}">
                                <i class="bi bi-box-seam-fill me-1"></i> Paket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Request::is('admin/broadcast*') ? 'active' : '' }}" href="{{ route('admin.broadcast') }}">
                                <i class="bi bi-whatsapp me-1"></i> Broadcast
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.logs') }}">
                                <i class="bi bi-clock-history me-1"></i> Log
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="cp-nav-link nav-link {{ Request::is('pelanggan/dashboard') ? 'active' : '' }}" href="/pelanggan/dashboard">
                                <i class="bi bi-wallet2 me-1"></i> Status Tagihan
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <div class="dropdown">
                            <button class="cp-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <div class="cp-user-avatar">
                                    {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                </div>
                                {{ auth()->user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end cp-dropdown">
                                <li class="px-3 py-2 mb-1">
                                    <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Login sebagai</small>
                                    <span class="fw-bold text-capitalize" style="color: var(--primary);">{{ auth()->user()->role }}</span>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('password.edit') }}">
                                        <i class="bi bi-key-fill" style="color: var(--primary);"></i> Ganti Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="/logout">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>

    <div class="cp-main">
        <div class="container">
            @if(session('success'))
                <div class="cp-alert success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>
                        <strong>Berhasil!</strong><br>
                        <span style="font-size: 0.85rem;">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="cp-alert error alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>
                        <strong>Gagal!</strong><br>
                        <span style="font-size: 0.85rem;">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer class="cp-footer">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <p class="cp-footer-text mb-0">&copy; 2026 <strong>ConnectPay</strong> &mdash; Solusi Pembayaran Internet Terpercaya</p>
                <span class="cp-footer-badge">v1.0.4</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.cp-navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.cp-alert').forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>