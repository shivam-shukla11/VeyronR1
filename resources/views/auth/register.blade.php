<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Vogue</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f5f6fa;
        }

        .logo {
            height: 80px;
            border-radius: 60%;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            margin-bottom: 1.5rem;
        }

        #registerbox {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.8s ease;
        }

        .registerheader {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .smallheader {
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1rem;
            color: #555;
        }

        .registerbody input {
            width: 100%;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .registerbody input:focus {
            outline: none;
            border-color: #2c2f4a;
        }

        .registerbody input.error {
            border-color: #dc3545;
        }

        .name-row {
            display: flex;
            gap: 1rem;
        }

        .name-row input {
            flex: 1;
        }

        .field-hint {
            font-size: 0.75rem;
            color: #666;
            margin-top: -0.8rem;
            margin-bottom: 1rem;
        }

        .password-strength {
            height: 4px;
            background: #ddd;
            border-radius: 2px;
            margin-top: -0.8rem;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }

        .registerbody button.continue {
            width: 100%;
            padding: 0.8rem 1rem;
            background: #2c2f4a;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .registerbody button.continue:hover {
            transform: translateY(-2px);
        }

        #registerbox p {
            margin-top: 1rem;
            text-align: center;
            color: #555;
        }

        #registerbox p span {
            color: #2c2f4a;
            cursor: pointer;
            font-weight: 500;
            text-decoration: underline;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/voguelogo.jpg') }}" alt="Vogue Logo" class="logo">

    <div id="registerbox">
        <div class="registerheader">Join Vogue</div>
        <div class="smallheader">Create your account</div>

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="registerbody" id="registerForm">
            @csrf
            <div class="name-row">
                <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
            </div>
            
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            <div class="field-hint">We'll send order confirmations to this email</div>
            
            <input type="tel" name="mobile" placeholder="Mobile Number (10 digits)" value="{{ old('mobile') }}" maxlength="10" pattern="[0-9]{10}" required>
            <div class="field-hint">Enter 10-digit mobile number without country code</div>
            
            <input type="password" name="password" id="password" placeholder="Password" required>
            <div class="password-strength">
                <div class="password-strength-bar" id="strengthBar"></div>
            </div>
            <div class="field-hint">Min 8 characters with uppercase, lowercase & number</div>
            
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit" class="continue">Create Account</button>
        </form>

        <p>Already have an account? <span onclick="window.location.href='{{ route('login') }}'">Login</span></p>
    </div>

    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strengthBar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/\d/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthBar.style.background = '#dc3545';
            } else if (strength <= 50) {
                strengthBar.style.background = '#ffc107';
            } else if (strength <= 75) {
                strengthBar.style.background = '#17a2b8';
            } else {
                strengthBar.style.background = '#28a745';
            }
        });

        // Mobile number - only allow digits
        document.querySelector('input[name="mobile"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });

        // Name fields - only allow letters and spaces
        document.querySelectorAll('input[name="first_name"], input[name="last_name"]').forEach(function(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        });
    </script>
</body>
</html>
