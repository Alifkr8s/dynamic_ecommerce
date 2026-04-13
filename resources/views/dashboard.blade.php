<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard | GroupBuy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #e4ecf7);
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .welcome-box {
            padding: 40px;
        }

        .btn-custom {
            border-radius: 30px;
            padding: 10px 25px;
        }

        a.card-link {
            text-decoration: none;
            color: inherit;
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

            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>

    </div>
</nav>

<!-- DASHBOARD -->
<div class="container mt-5">

    <!-- MAIN CARD -->
    <div class="card shadow-lg">
        <div class="card-body text-center welcome-box">

            <h2 class="fw-bold text-primary mb-3">
                Welcome to Your Dashboard 🎉
            </h2>

            <p class="text-muted mb-4">
                Manage your deals, track group participation, and unlock better pricing.
            </p>

            <div class="d-flex justify-content-center gap-3">

                <a href="/deal/1" class="btn btn-success btn-custom">
                    🔥 View Live Deal
                </a>

                <a href="/demo-deal" class="btn btn-outline-primary btn-custom">
                    📊 Demo Deal
                </a>

            </div>

        </div>
    </div>

    <!-- FEATURE CARDS -->
    <div class="row mt-4 text-center">

        <!-- PARTICIPANTS -->
        <div class="col-md-4">
            <a href="{{ route('participants.page') }}" class="card-link">
                <div class="card shadow-sm p-3">
                    <h5>👥 Participants</h5>
                    <p class="text-muted">Track live users joining deals</p>
                </div>
            </a>
        </div>

        <!-- PRICING -->
        <div class="col-md-4">
            <a href="{{ route('pricing.page') }}" class="card-link">
                <div class="card shadow-sm p-3">
                    <h5>💸 Dynamic Pricing</h5>
                    <p class="text-muted">Price decreases as users join</p>
                </div>
            </a>
        </div>

        <!-- ORDERS -->
        <div class="col-md-4">
            <a href="{{ route('orders.page') }}" class="card-link">
                <div class="card shadow-sm p-3">
                    <h5>📦 Orders</h5>
                    <p class="text-muted">Manage your purchases easily</p>
                </div>
            </a>
        </div>

    </div>

</div>

</body>
</html>