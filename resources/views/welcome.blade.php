<!DOCTYPE html>
<html>
<head>
    <title>GroupBuy Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">GroupBuy Platform</span>

    <div>
        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-warning me-2">Sign Up</a>
        <a href="/admin/login" class="btn btn-danger">Admin</a>
    </div>
</nav>

<!-- HERO -->
<div class="container mt-5">
    <div class="p-5 bg-white rounded shadow text-center">
        <h1 class="text-primary fw-bold">Smart Group Buying Platform</h1>
        <p class="mt-3">
            Buy together, pay less. Join deals and unlock better prices.
        </p>

        <a href="/deal/1" class="btn btn-primary mt-3">
            Explore Live Deal 🚀
        </a>
    </div>
</div>

<!-- FOOTER -->
<div class="text-center mt-5 p-3 text-muted">
    © 2026 GroupBuy Platform
</div>

</body>
</html>