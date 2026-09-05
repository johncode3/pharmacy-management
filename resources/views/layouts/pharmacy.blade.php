<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PharmaCare - @yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    @yield('extra-css')
</head>
<body>

    <aside class="sidebar">
        <div>

            <div class="sidebar-logo">
                <img src="{{ asset('assets/images/PharmacyLogo.png') }}" alt="PharmaCare Logo" style="width: 32px; height: 32px; border-radius: 6px;">
                <span>PharmaCare</span>
            </div>  

            <div class="user-badge-box">
                <span>Role:</span>
                <span class="role-pill {{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isPharmacist())
                    <div class="nav-header">Inventory</div>
                    
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags-fill"></i>
                        <span>Categories</span>
                    </a>

                    <a href="{{ route('medicines.index') }}" class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                        <i class="bi bi-capsule"></i>
                        <span>Medicines</span>
                    </a>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isCashier())
                    <div class="nav-header">Sales & POS</div>

                    <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                        <i class="bi bi-calculator-fill"></i>
                        <span>POS Checkout</span>
                    </a>

                    <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Sales History</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="sidebar-footer" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-top: 1px solid var(--slate-800);">

        <a href="{{ route('profile.edit') }}" style="text-decoration: none; flex: 1; min-width: 0; margin-right: 10px;" title="View & Edit Profile">
            <div class="user-name" style="color: #ffffff; font-size: 0.88rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ auth()->user()->name }}
            </div>
            <div style="font-size: 0.75rem; color: var(--slate-400); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ auth()->user()->email }}
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 8px;">
            <a href="{{ route('profile.edit') }}" class="btn-logout" title="Profile Settings" style="color: var(--slate-400); text-decoration: none; display: flex; align-items: center;">
                <i class="bi bi-person-gear"></i>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout" title="Log Out">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>

    </div>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <h1 class="top-title">@yield('page-title', 'Dashboard')</h1>
            <div style="font-size: 0.85rem; color: var(--slate-500);">
                <i class="bi bi-clock"></i> {{ now()->format('l, d M Y') }}
            </div>
        </header>

        <div class="content-container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>