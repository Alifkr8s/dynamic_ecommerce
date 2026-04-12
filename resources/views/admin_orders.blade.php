<!DOCTYPE html>
<html>

<head>

<title>Admin Payment Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Admin Payment Dashboard</h2>

@if(session('status'))
<div class="alert alert-success">
{{ session('status') }}
</div>
@endif

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>User</th>
<th>Deal</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>{{ $payment->user_id }}</td>

<td>{{ $payment->deal_id }}</td>

<td>${{ $payment->amount }}</td>

<td>

@if($payment->status == 'pending')

<span class="badge bg-warning">Pending</span>

@else

<span class="badge bg-success">Approved</span>

@endif

</td>

<td>

@if($payment->status == 'pending')

<form method="POST" action="/admin/orders/{{ $payment->id }}/approve">

@csrf

<button class="btn btn-success btn-sm">

Approve

</button>

</form>

@endif

<a href="/admin/bill/{{ $payment->id }}" class="btn btn-primary btn-sm mt-1">

Generate Bill

</a>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center">

No payment requests yet

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</body>

</html>