<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VEYRON - Fashion Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: #fafafa; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        header {
            background: #fff;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .logo img { height: 45px; border-radius: 50%; }
        .logo span { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.6rem; 
            font-weight: 500; 
            color: #111; 
            letter-spacing: 3px;
        }
        
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 400;
            font-size: 0.95rem;
            padding: 0.6rem 1.5rem;
            border: 1px solid #111;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }
        nav a:hover { background: #111; color: #fff; }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
        }
        
        .content {
            text-align: center;
            max-width: 600px;
        }
        
        .content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 400;
            color: #111;
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }
        
        .content .tagline {
            font-size: 1.1rem;
            color: #666;
            font-weight: 300;
            margin-bottom: 3rem;
            letter-spacing: 1px;
        }
        
        .divider {
            width: 60px;
            height: 1px;
            background: #111;
            margin: 0 auto 3rem;
        }
        
        .notice {
            background: #fff;
            border: 1px solid #e5e5e5;
            padding: 2rem 3rem;
            margin-top: 2rem;
        }
        .notice h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 500;
            color: #111;
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
        }
        .notice p {
            font-size: 0.9rem;
            color: #888;
            font-weight: 300;
        }

        /* Footer */
        footer {
            background: #fff;
            border-top: 1px solid #eee;
            text-align: center;
            padding: 1.5rem;
            color: #999;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        /* Success Popup */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .popup-overlay.show { display: flex; }
        .popup {
            background: #fff;
            padding: 3rem 4rem;
            text-align: center;
            animation: fadeIn 0.3s ease;
            border: 1px solid #e5e5e5;
        }
        .popup .checkmark {
            width: 50px; height: 50px;
            border: 2px solid #111;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
        }
        .popup h2 { 
            font-family: 'Playfair Display', serif;
            color: #111; 
            font-weight: 500;
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
        }
        .popup p { color: #666; margin-bottom: 1.5rem; font-weight: 300; }
        .popup button {
            background: #111;
            color: #fff;
            border: none;
            padding: 0.8rem 2.5rem;
            font-size: 0.9rem;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background 0.3s;
        }
        .popup button:hover { background: #333; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .content h1 { font-size: 2.5rem; }
            header { padding: 1rem 1.5rem; }
            .notice { padding: 1.5rem 2rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/voguelogo.jpg') }}" alt="Veyron">
            <span>VEYRON</span>
        </div>
        <nav>
            @auth
                <a href="{{ route('logout') }}">LOGOUT</a>
            @else
                <a href="{{ route('login') }}">LOGIN</a>
            @endauth
        </nav>
    </header>

    <main>
        <div class="content">
            <h1>VEYRON</h1>
            <p class="tagline">Fashion that speaks, style that lasts.</p>
            <div class="divider"></div>
            
            <div class="notice">
                <h3>COMING SOON</h3>
                <p>We're crafting something beautiful. Stay tuned.</p>
            </div>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} VEYRON. All rights reserved.
    </footer>

    @if(session('success'))
    <div class="popup-overlay show" id="successPopup">
        <div class="popup">
            <div class="checkmark">&#10003;</div>
            <h2>SUCCESS</h2>
            <p>{{ session('success') }}</p>
            <button onclick="closePopup()">CONTINUE</button>
        </div>
    </div>
    @endif

    <script>
        function closePopup() {
            document.getElementById('successPopup').classList.remove('show');
        }
        setTimeout(function() {
            var popup = document.getElementById('successPopup');
            if(popup) popup.classList.remove('show');
        }, 3000);
    </script>
</body>
</html>
