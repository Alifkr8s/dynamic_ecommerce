<!DOCTYPE html>
<html>

<head>
    <title>Payment Bill</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">
<h2>Payment Invoice</h2>
</div>

<div class="card-body">

<p><strong>Payment ID:</strong> {{ $payment->id }}</p>

<p><strong>User ID:</strong> {{ $payment->user_id }}</p>

<p><strong>Deal ID:</strong> {{ $payment->deal_id }}</p>

<p><strong>Amount Paid:</strong> ${{ $payment->amount }}</p>

<p><strong>Status:</strong>
@if($payment->status == 'approved')
<span class="badge bg-success">Approved</span>
@else
<span class="badge bg-warning">Pending</span>
@endif
</p>

<p><strong>Date:</strong> {{ $payment->created_at }}</p>

<hr>

<button onclick="window.print()" class="btn btn-success">
Print Bill
</button>

<a href="/admin/orders" class="btn btn-secondary">
Back to Dashboard
</a>

</div>

</div>

</div>

</body>

</html>