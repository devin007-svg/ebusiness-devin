<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #6777ef;
            --sidebar-bg: #ffffff;
            --sidebar-text: #34395e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar.collapsed { left: calc(-1 * var(--sidebar-width)); }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #f4f6f9;
        }
        .sidebar-brand h4 { color: var(--primary-color); font-weight: 700; margin: 0; }

        .sidebar-menu { list-style: none; padding: 20px 0; }
        .sidebar-menu li { margin: 5px 0; }
        .sidebar-menu a {
            display: flex; align-items: center;
            padding: 12px 25px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: var(--primary-color); color: white; }
        .sidebar-menu i { margin-right: 15px; width: 20px; text-align: center; }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }
        .main-content.expanded { margin-left: 0; }

        /* Navbar */
        .navbar-custom {
            background: white;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            padding: 15px 30px;
        }
        .navbar-toggler {
            border: none; font-size: 24px; color: var(--sidebar-text);
            cursor: pointer; background: none;
        }
        .navbar-user { display: flex; align-items: center; gap: 15px; }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--primary-color);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600;
        }

        .user-dropdown { position: relative; }
        .user-dropdown-toggle {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; padding: 8px 12px; border-radius: 8px;
            transition: all 0.3s; background: none; border: none;
        }
        .user-dropdown-toggle:hover { background: #f4f6f9; }
        .user-dropdown-menu {
            position: absolute; top: 100%; right: 0; margin-top: 10px;
            background: white; border-radius: 8px; box-shadow: 0 8px 25px 0 rgba(0,0,0,.15);
            min-width: 220px; opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s; z-index: 1001;
        }
        .user-dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .user-dropdown-header { padding: 15px 20px; border-bottom: 1px solid #f4f6f9; }
        .user-dropdown-name { font-weight: 600; color: #34395e; margin-bottom: 3px; }
        .user-dropdown-email { font-size: 13px; color: #6c757d; }
        .user-dropdown-body { padding: 10px 0; }
        .user-dropdown-item {
            display: flex; align-items: center; padding: 10px 20px;
            color: #34395e; text-decoration: none; transition: all 0.3s;
            width: 100%; text-align: left; background: none; border: none;
        }
        .user-dropdown-item:hover { background: #f4f6f9; color: var(--primary-color); }
        .user-dropdown-item i { margin-right: 12px; width: 18px; }
        .user-dropdown-divider { height: 1px; background: #f4f6f9; margin: 10px 0; }

        /* Content */
        .dashboard-content { padding: 30px; }
        .page-title { font-size: 28px; font-weight: 700; color: #34395e; margin-bottom: 10px; }
        .welcome-text { color: #6c757d; margin-bottom: 25px; }

        /* Product cards */
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.08);
            overflow: hidden;
            transition: .25s;
            height: 100%;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 10px 35px rgba(0,0,0,.12); }
        .product-img {
            height: 160px; width: 100%;
            object-fit: cover;
            background: #f2f3f5;
        }
        .product-body { padding: 16px; }
        .product-title { font-weight: 700; margin: 0; color: #34395e; }
        .product-meta { font-size: 13px; color: #6c757d; margin-top: 4px; }
        .product-price { font-size: 18px; font-weight: 800; color: #34395e; margin-top: 10px; }
        .stock-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 600;
        }
        .stock-ok { background: #e9f7ef; color: #1e7e34; }
        .stock-low { background: #fff3cd; color: #856404; }
        .stock-out { background: #f8d7da; color: #721c24; }

        @media (max-width: 768px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>

<body>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-cube"></i> {{ config('app.name', 'MyApp') }}</h4>
    </div>
    <ul class="sidebar-menu">
        <li><a href="#" class="active"><i class="fas fa-store"></i> Produk</a></li>
        <li>
    <a href="{{ route('cart.index') }}">
        <i class="fas fa-shopping-cart"></i> Keranjang
    </a>
</li>

    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="d-flex justify-content-between align-items-center w-100">
            <button class="navbar-toggler" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="navbar-user">
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" id="userDropdownToggle">
                        <span class="text-muted d-none d-md-inline">{{ Auth::user()->name }}</span>
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    </button>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                            <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="user-dropdown-body">
                            <a href="#" class="user-dropdown-item">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <div class="user-dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="user-dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <!-- Content -->
    <div class="dashboard-content">
        <h1 class="page-title">Produk</h1>
        <p class="welcome-text">Silakan pilih produk yang ingin Anda beli, lalu klik <b>Tambah ke Keranjang</b>.</p>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- Products Grid --}}
        <div class="row g-4">
            @forelse($products as $product)
                @php
                    $stock = (int)($product->stock ?? 0);
                    $badgeClass = $stock <= 0 ? 'stock-out' : ($stock < 10 ? 'stock-low' : 'stock-ok');
                    $badgeText  = $stock <= 0 ? 'Stok Habis' : ($stock < 10 ? 'Stok Menipis' : 'Stok Tersedia');
                @endphp

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="product-card">
                        @if(!empty($product->image))
                            <img src="{{ asset('storage/'.$product->image) }}" class="product-img" alt="{{ $product->name }}">
                        @else
                            <div class="product-img d-flex align-items-center justify-content-center">
                                <i class="fas fa-box text-secondary fs-1"></i>
                            </div>
                        @endif

                        <div class="product-body">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-meta">
                                SKU: {{ $product->sku ?? '-' }} • {{ $product->category ?? 'Tanpa kategori' }}
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="stock-badge {{ $badgeClass }}">
                                    <i class="fas fa-cubes"></i> {{ $stock }} {{ $product->unit ?? '' }}
                                </span>
                            </div>

                            <div class="product-price">
                                Rp {{ number_format($product->selling_price ?? ($product->price ?? 0), 0, ',', '.') }}
                            </div>

                            <div class="mt-3">
                                @if($stock > 0)
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-grid gap-2">
                                        @csrf
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada produk terdaftar.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    sidebarToggle.addEventListener('click', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        } else {
            sidebar.classList.toggle('show');
        }
    });

    // User Dropdown Toggle
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    userDropdownToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
            userDropdownMenu.classList.remove('show');
        }
    });

    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>
</body>
</html>
