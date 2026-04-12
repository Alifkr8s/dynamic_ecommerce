<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header bg-dark text-white text-center">
<h3>Admin Login</h3>
</div>

<div class="card-body">

@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>

@endif

<form method="POST" action="/admin/login">

@csrf

<div class="mb-3">

<label>Email</label>

<input type="email" name="email" class="form-control" required>

</div>

<div class="mb-3">

<label>Password</label>

<input type="password" name="password" class="form-control" required>

</div>

<button class="btn btn-dark w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>