<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard — VOGUE')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Arial', sans-serif; background:#f4f4f4; }
        
        .header { background:#222; color:#fff; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; box-shadow:0 4px 10px rgba(0,0,0,0.2); }
        .header .logo { display:flex; align-items:center; gap:0.5rem; font-size:1.5rem; font-weight:bold; }
        .header .logo img { height:40px; border-radius:5px; }
        .nav a { color:#fff; text-decoration:none; margin-left:1.5rem; font-weight:500; padding:0.5rem 1rem; border-radius:5px; transition: all 0.3s ease; display:inline-flex; align-items:center; gap:0.3rem; }
        .nav a.active { background:#ff4d6d; transform:scale(1.05); }
        .nav a:hover { background:#ff4d6d; transform:scale(1.05); }
        
        .container { max-width:1200px; margin:2rem auto; padding:0 1rem; }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="{{ asset('images/voguelogo.jpg') }}" alt="VOGUE Logo">
            <span>VOGUE Admin</span>
        </div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="material-icons">dashboard</span> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="material-icons">inventory</span> Products
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="material-icons">shopping_cart</span> Orders
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="material-icons">people</span> Users
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="material-icons">category</span> Categories
            </a>
            <a href="{{ route('admin.logout') }}">
                <span class="material-icons">logout</span> Logout
            </a>
        </nav>
    </header>

    <div class="container">
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:1rem;">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
