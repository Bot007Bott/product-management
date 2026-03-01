<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopManager Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #1a73e8, #0d47a1) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 12px 0;
        }

        .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: white !important;
            letter-spacing: 1px;
        }

        .navbar-brand span {
            color: #90caf9;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 6px 14px !important;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white !important;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            padding: 6px 16px !important;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(255, 0, 0, 0.3);
        }

        /* SIDEBAR for admin */
        .admin-wrapper {
            display: flex;
            min-height: calc(100vh - 60px);
        }

        .sidebar {
            width: 240px;
            background: #1e293b;
            min-height: calc(100vh - 60px);
            padding: 20px 0;
            position: fixed;
            top: 67.5px;
            left: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #94a3b8;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            border-left: 3px solid #1a73e8;
        }

        .sidebar a i {
            width: 20px;
        }

        .sidebar-section {
            color: #475569;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 16px 20px 6px;
        }

        .admin-content {
            margin-left: 240px;
            padding: 30px;
            width: calc(100% - 240px);
        }

        /* CARDS */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        /* STAT CARDS */
        .stat-card {
            border-radius: 12px;
            padding: 24px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card i {
            font-size: 2.5rem;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-card p {
            opacity: 0.85;
            margin: 0;
        }

        /* TABLES */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: #1e293b;
            color: white;
            font-weight: 600;
            border: none;
            padding: 14px 16px;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* BUTTONS */
        .btn-primary {
            background: #1a73e8;
            border-color: #1a73e8;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: #1557b0;
            border-color: #1557b0;
        }

        .btn-warning {
            border-radius: 8px;
        }

        .btn-danger {
            border-radius: 8px;
        }

        .btn-success {
            border-radius: 8px;
        }

        /* FORMS */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        .page-header h2 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        /* PRODUCT CARDS (customer) */
        .product-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .product-img {
            height: 180px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .product-card .card-body {
            padding: 16px;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a73e8;
        }

        .badge-category {
            background: #e3f2fd;
            color: #1a73e8;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ALERTS */
        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: white;
            padding: 40px 30px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        /* CUSTOMER WRAPPER */
        .customer-content {
            padding: 30px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand"
                href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}">
                <i class="fas fa-store me-2"></i>Shop<span>Manager</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <span class="text-white me-2 d-none d-md-block">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                        <span class="badge ms-1" style="background:rgba(255,255,255,0.2)">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </span>
                    @if (!auth()->user()->isAdmin())
                        <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home me-1"></i>Home</a>
                        <a href="{{ route('customer.orders') }}" class="nav-link"><i class="fas fa-box me-1"></i>My
                            Orders</a>
                        <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            @if ($cartCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    @auth
        @if (auth()->user()->isAdmin())
            <div class="admin-wrapper">
                <div class="sidebar">
                    <div class="sidebar-section">Main Menu</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <div class="sidebar-section">Management</div>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                        class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <i class="fas fa-box-open"></i> Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </div>
                <div class="admin-content">
                    @if (session('success'))
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger"><i
                                class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                    @endif
                    @yield('content')
                </div>
            </div>
        @else
            <div class="customer-content">
                @if (session('success'))
                    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        @endif
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
