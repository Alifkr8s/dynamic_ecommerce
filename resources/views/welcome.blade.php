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


<!-- HERO SECTION -->
<div class="container mt-5">
    <div class="p-5 mb-4 bg-white rounded-4 shadow text-center">

        <h1 class="display-5 fw-bold text-primary">
            Smart Group Buying Platform
        </h1>

        <p class="lead mt-3">
            Buy together, pay less. Join deals, track participants in real-time,
            and unlock better prices instantly.
        </p>

        <a href="/deal/1" class="btn btn-primary btn-lg mt-3 px-4">
            Explore Live Deal 🚀
        </a>

    </div>
</div>


<!-- FEATURES SECTION -->
<div class="container mt-5">

    <h2 class="text-center mb-4 fw-bold">Core Features</h2>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>⏳ Countdown Timer</h5>
                <p>Deals expire automatically with real-time countdown.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>👥 Live Participants</h5>
                <p>Track how many users joined instantly.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>💰 Dynamic Pricing</h5>
                <p>Price drops as more users join the deal.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>💳 Admin Payment</h5>
                <p>Secure payment approval by admin.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>🧾 Invoice System</h5>
                <p>Automatic bill generation after approval.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-3">
                <h5>🔔 Notifications</h5>
                <p>Get alerts for deal updates and payment status.</p>
            </div>
        </div>

    </div>
</div>


<!-- HOW IT WORKS -->
<div class="container mt-5">
    <div class="bg-white p-5 rounded-4 shadow text-center">

        <h2 class="fw-bold mb-4">How It Works</h2>

        <div class="row">

            <div class="col-md-4">
                <h4>1️⃣ Join Deal</h4>
                <p>Select a deal and join with others.</p>
            </div>

            <div class="col-md-4">
                <h4>2️⃣ Price Drops</h4>
                <p>More participants → lower price.</p>
            </div>

            <div class="col-md-4">
                <h4>3️⃣ Pay & Confirm</h4>
                <p>Admin approves → invoice generated.</p>
            </div>

        </div>

    </div>
</div>


<!-- FOOTER -->
<div class="text-center mt-5 p-3 text-muted">
    © 2026 GroupBuy Platform | CSE471 Project
</div>

</body>
</html>