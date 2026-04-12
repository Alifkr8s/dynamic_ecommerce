<!DOCTYPE html>
<html lang="en">

<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand">GroupBuy Platform</a>

<div>

<span class="text-white me-3">

Welcome, {{ Auth::user()->name }}

</span>

<form method="POST" action="{{ route('logout') }}" class="d-inline">

@csrf

<button class="btn btn-danger btn-sm">
Logout
</button>

</form>

</div>

</div>

</nav>


<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

Dashboard

</div>

<div class="card-body text-center">

<h4>You are logged in!</h4>

<p class="text-muted">

Welcome to your Dynamic Group Buying Platform.

</p>

<a href="/deal/1" class="btn btn-success">

View Active Deal

</a>

</div>

</div>

</div>

</body>

</html>