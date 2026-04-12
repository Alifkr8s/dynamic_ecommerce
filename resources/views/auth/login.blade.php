<!DOCTYPE html>
<html lang="en">
<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header text-center bg-primary text-white">
<h4>Login</h4>
</div>

<div class="card-body">

<form method="POST" action="{{ route('login') }}">

@csrf

<div class="mb-3">

<label>Email</label>

<input type="email" name="email" class="form-control" required>

</div>

<div class="mb-3">

<label>Password</label>

<input type="password" name="password" class="form-control" required>

</div>

<div class="form-check mb-3">

<input type="checkbox" name="remember" class="form-check-input">

<label class="form-check-label">Remember me</label>

</div>

<button class="btn btn-primary w-100">

Login

</button>

</form>

<div class="text-center mt-3">

<a href="{{ route('password.request') }}">Forgot Password?</a>

</div>

<hr>

<div class="text-center">

<a href="{{ route('register') }}" class="btn btn-warning">

Create Account

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>