<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConnectPay - Payment System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #00a8ff;
            --light-blue: #e3f2fd;
            --soft-blue: #f8fbff;
            --dark-blue: #0077b6;
            --text-dark: #2d3436;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-blue);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar {
            background-color: white !important;
            border-bottom: 2px solid var(--light-blue);
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0, 168, 255, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        /* Card Styling */
        .card-custom {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--light-blue);
            box-shadow: 0 4px 20px rgba(0, 168, 255, 0.05);
            padding: 25px;
        }

        /* Button Styling */
        .btn-connect {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-connect:hover {
            background-color: var(--dark-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 168, 255, 0.2);
        }

        /* Table Styling */
        .table thead {
            background-color: var(--light-blue);
            color: var(--dark-blue);
        }

        .table th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: #f0faff;
            transition: 0.2s;
        }

        /* Navigation Links */
        .nav-link {
            color: #636e72;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-blue);
            background-color: var(--light-blue);
        }

        .nav-link.active {
            color: var(--primary-blue) !important;
            background-color: var(--light-blue);
            font-weight: 600;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 10px;
        }

        footer {
            background-color: white;
            border-top: 1px solid var(--light-blue);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-broadcast"></i> Connect<span style="color: #0984e3">Pay</span>
            </a>
            
            @auth
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Request::is('admin/pelanggan*') ? 'active' : '' }}" href="/admin/pelanggan">
                                <i class="bi bi-people me-1"></i> Data Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Request::is('admin/pakets*') ? 'active' : '' }}" href="{{ route('pakets.index') }}">
                                <i class="bi bi-box me-1"></i> Data Paket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Request::is('admin/broadcast*') ? 'active' : '' }}" href="{{ route('admin.broadcast') }}">
                                <i class="bi bi-whatsapp me-1"></i> Broadcast WA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.logs') }}">
                                <i class="bi bi-clock-history me-1"></i> Log Aktivitas
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link mx-1 {{ Request::is('pelanggan/dashboard') ? 'active' : '' }}" href="/pelanggan/dashboard">
                                <i class="bi bi-wallet2 me-1"></i> Status Tagihan
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle btn-sm px-3 w-100" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li class="px-3 py-2 border-bottom mb-2">
                                    <small class="text-muted d-block">Login sebagai:</small>
                                    <span class="fw-bold text-capitalize text-primary">{{ auth()->user()->role }}</span>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('password.edit') }}">
                                        <i class="bi bi-key me-2"></i> Ganti Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger d-flex align-items-center" href="/logout">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
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

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #d1e7dd; color: #0f5132;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Berhasil!</strong><br>
                        {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #f8d7da; color: #842029;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Gagal!</strong><br>
                        {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center py-4 mt-auto">
        <div class="container">
            <p class="text-muted small mb-0">&copy; 2026 <strong>ConnectPay</strong> - Solusi Pembayaran Internet Terpercaya</p>
            <div class="mt-2">
                <span class="badge bg-light text-primary border">v1.0.4</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>