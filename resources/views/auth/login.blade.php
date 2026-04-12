<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        h1, h2, h3, h4, h5 { font-family: 'Syne', sans-serif; }

        /* Navbar */
        .navbar {
            background: rgba(17,17,17,0.95);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary) !important;
            text-decoration: none;
            letter-spacing: -0.02em;
        }

        /* Page layout */
        .login-wrapper {
            min-height: calc(100vh - 65px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }
        .login-wrapper::before {
            content: '';
            position: absolute;
            top: -200px; right: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,107,43,0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .login-wrapper::after {
            content: '';
            position: absolute;
            bottom: -150px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,107,43,0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Card */
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #ff9a5c);
            border-radius: 16px 16px 0 0;
        }

        /* Header */
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header .brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }
        .login-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        /* Form elements */
        .form-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: #ccc;
            margin-bottom: 0.4rem;
            display: block;
        }
        .form-control {
            background: #111;
            border: 1px solid var(--border);
            color: #fff;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            background: #111;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255,107,43,0.15);
            color: #fff;
        }
        .form-control::placeholder { color: #555; }
        .form-control.is-invalid { border-color: #dc3545; }

        .error-text {
            color: #dc3545;
            font-size: 0.78rem;
            margin-top: 0.3rem;
        }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #aaa;
            cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            accent-color: var(--primary);
            width: 15px;
            height: 15px;
        }
        .forgot-link {
            font-size: 0.82rem;
            color: var(--primary);
            text-decoration: none;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
        }
        .forgot-link:hover { color: #ff9a5c; text-decoration: underline; }

        /* Submit button */
        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 0.8rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.01em;
        }
        .btn-login:hover { background: #e55a1f; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-family: 'Syne', sans-serif;
        }

        /* Quick login hints */
        .hint-box {
            background: #111;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem;
        }
        .hint-box .hint-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.7rem;
        }
        .hint-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.82rem;
        }
        .hint-item:last-child { border-bottom: none; }
        .hint-item .role {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: #aaa;
        }
        .hint-item .email {
            color: #ccc;
            font-size: 0.8rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .hint-item .email:hover { color: var(--primary); }

        /* Session error */
        .session-error {
            background: #2a0000;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }

        /* Back link */
        .back-to-home {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-to-home:hover { color: var(--primary); }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="navbar-brand">TierMart</a>
    </div>
</nav>

{{-- Login Wrapper --}}
<div class="login-wrapper">
    <div class="login-card">

        {{-- Header --}}
        <div class="login-header">
            <div class="brand">TierMart</div>
            <h2>Welcome back</h2>
            <p>Login to access your account</p>
        </div>

        {{-- Session Error --}}
        @if (session('status'))
            <div class="session-error" style="background:#002a1a; border-color:#28a745; color:#28a745;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="session-error">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom: 1.2rem;">
                <label class="form-label" for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 1.2rem;">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login">Login to TierMart →</button>
        </form>

        {{-- Divider --}}
        <div class="divider"><span>Quick Login Hints</span></div>

        {{-- Hints --}}
        <div class="hint-box">
            <div class="hint-title">Test Accounts — password: "password"</div>
            <div class="hint-item">
                <span class="role">🏪 Vendor</span>
                <span class="email" onclick="fillEmail('rahim@example.com')">rahim@example.com ↗</span>
            </div>
            <div class="hint-item">
                <span class="role">🏪 Vendor</span>
                <span class="email" onclick="fillEmail('karim@example.com')">karim@example.com ↗</span>
            </div>
            <div class="hint-item">
                <span class="role">🛒 Buyer</span>
                <span class="email" onclick="fillEmail('tanvir@example.com')">tanvir@example.com ↗</span>
            </div>
            <div class="hint-item">
                <span class="role">⚙️ Admin</span>
                <span class="email" onclick="fillEmail('admin@example.com')">admin@example.com ↗</span>
            </div>
        </div>

        <a href="{{ url('/') }}" class="back-to-home">← Back to Home</a>
    </div>
</div>

<script>
    // Click on email hint to auto-fill the form
    function fillEmail(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
        document.getElementById('email').focus();
    }
</script>
</body>
</html>