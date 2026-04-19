<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1d976c, #93f9b9);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .card-header {
            background: #198754;
            color: white;
            font-size: 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            background: #198754;
            border: none;
        }

        .btn-primary:hover {
            background: #146c43;
        }
    </style>
</head>

<body>

<div class="card p-3">

    <div class="card-header">
        Create Account
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">
                Register
            </button>

        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="btn btn-link">
                Already Registered? Login
            </a>
        </div>

    </div>

</div>

</body>
</html>