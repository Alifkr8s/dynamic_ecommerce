<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dynamic Pricing | GroupBuy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #dbe7f3);
        }

        .card {
            border-radius: 15px;
        }

        .price-box {
            font-size: 2rem;
            font-weight: bold;
            color: #198754;
        }

        .tier {
            transition: 0.3s;
        }

        .tier:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark shadow">
    <div class="container d-flex justify-content-between">
        <span class="navbar-brand">🚀 GroupBuy</span>

        <div>
            <span class="text-white me-3">
                👋 {{ Auth::user()->name }}
            </span>

            <a href="/dashboard" class="btn btn-outline-light btn-sm">Dashboard</a>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-5">

    <!-- HEADER -->
    <div class="card shadow-lg mb-4">
        <div class="card-body text-center">
            <h2 class="fw-bold text-success">💸 Dynamic Pricing System</h2>
            <p class="text-muted">
                Price decreases as more users join the deal
            </p>

            <div class="price-box">
                Current Price: ৳ {{ $currentPrice ?? 1000 }}
            </div>

            <span class="badge bg-primary mt-2">
                Participants: {{ $participants ?? 0 }}
            </span>
        </div>
    </div>

    <!-- TIERS -->
    <div class="row text-center">

        <div class="col-md-3">
            <div class="card shadow p-3 tier">
                <h5>🔥 Tier 1</h5>
                <p>1–5 Users</p>
                <h4 class="text-danger">৳1000</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 tier">
                <h5>⚡ Tier 2</h5>
                <p>6–10 Users</p>
                <h4 class="text-warning">৳900</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 tier">
                <h5>🚀 Tier 3</h5>
                <p>11–20 Users</p>
                <h4 class="text-primary">৳800</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow p-3 tier">
                <h5>🏆 Tier 4</h5>
                <p>21+ Users</p>
                <h4 class="text-success">৳700</h4>
            </div>
        </div>

    </div>

    <!-- INFO -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h5> How it works?</h5>
            <ul class="text-muted">
                <li>More participants → Lower price</li>
                <li>System automatically updates price</li>
                <li>Encourages group buying</li>
            </ul>
        </div>
    </div>

</div>

</body>
</html>