<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }

        .navbar {
            background: #111;
            padding: 15px;
        }

        .navbar h2 {
            color: #ff6a00;
            margin: 0;
        }

        .login-card {
            background: #111;
            color: white;
            border-radius: 15px;
            padding: 30px;
            width: 400px;
            margin: 80px auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .login-card input {
            background: #222;
            border: 1px solid #444;
            color: white;
        }

        .login-card input:focus {
            background: #222;
            color: white;
            border-color: #ff6a00;
        }

        .btn-orange {
            background: #ff6a00;
            border: none;
            color: white;
        }

        .btn-orange:hover {
            background: #e65c00;
        }

        .text-orange {
            color: #ff6a00;
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>TierMart</h2>
</div>

<div class="login-card">

    <h3 class="text-orange text-center">Welcome back</h3>
    <p class="text-center">Login to access your account</p>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <input type="checkbox" name="remember"> Remember me
        </div>

        <button class="btn btn-orange w-100">
            Login
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="{{ route('password.request') }}" class="text-orange">
            Forgot password?
        </a>
    </div>

    <hr style="background:white;">

    <div class="text-center">
        <a href="{{ route('register') }}" class="btn btn-warning">
            Create Account
        </a>
    </div>

</div>

</body>
</html>