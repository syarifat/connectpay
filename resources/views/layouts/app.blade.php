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
        }

        /* Navbar Styling */
        .navbar {
            background-color: white !important;
            border-bottom: 2px solid var(--light-blue);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
            font-size: 1.5rem;
        }

        /* Card Styling */
        .card-custom {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--light-blue);
            box-shadow: 0 4px 20px rgba(0, 168, 255, 0.05);
            padding: 20px;
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
        }

        /* Table Styling */
        .table thead {
            background-color: var(--light-blue);
            color: var(--dark-blue);
        }

        .table th {
            border: none;
            font-weight: 600;
        }

        /* Sidebar/Navigation Links */
        .nav-link {
            color: #636e72;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue);
        }

        .badge-status {
            border-radius: 8px;
            padding: 5px 12px;
        }
        .table-hover tbody tr:hover {
            background-color: #f0faff; /* Biru sangat muda saat hover */
            transition: 0.2s;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-broadcast"></i> Connect<span style="color: #0984e3">Pay</span>
            </a>
            
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/admin/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/admin/pelanggan">Data Pelanggan</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/pelanggan/dashboard">Status Tagihan</a>
                        </li>
                    @endif
                    
                    <li class="nav-item ms-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle btn-sm px-3" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right"></i> Keluar</a></li>
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
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px; background-color: #d1e7dd; color: #0f5132;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="text-center py-4 mt-auto">
        <p class="text-muted small">&copy; 2026 ConnectPay - Solusi Pembayaran Internet</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>