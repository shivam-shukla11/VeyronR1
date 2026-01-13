<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'VOGUE')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="topbar container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/voguelogo.jpg') }}" alt="VOGUE Logo" style="height:50px;">
                </a>
                <span style="font-size: 18px; font-weight: 550; margin-left: 8px;">
                    Fashion that speaks, style that lasts.
                </span>
            </div>
            <nav class="nav">
                <a href="{{ route('home') }}"><span class="material-icons">home</span></a>
                <a href="{{ route('products.index') }}"><span class="material-icons">store</span></a>
                <a href="{{ route('cart.index') }}" class="cart-link">
                    <span class="material-icons">shopping_bag</span>
                    @if(session('cart_count', 0) > 0)
                        <span class="cart-badge">{{ session('cart_count') }}</span>
                    @endif
                </a>
                <a href="{{ route('wishlist.index') }}"><span class="material-icons">favorite_border</span></a>
                @auth
                    <a href="{{ route('account.index') }}"><span class="material-icons">account_circle</span></a>
                @else
                    <a href="{{ route('login') }}"><span class="material-icons">account_circle</span></a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="inner">
                <div>
                    <strong>VOGUE</strong>
                    <p>Fashion that speaks, style that lasts.</p>
                </div>
                <div>
                    <strong>Links</strong>
                    <p><a href="{{ route('products.index') }}">Shop</a></p>
                    <p><a href="#">About</a></p>
                </div>
                <div>
                    <strong>Contact</strong>
                    <p>support@vogue.com</p>
                </div>
            </div>
            <small>&copy; {{ date('Y') }} VOGUE. All rights reserved.</small>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
