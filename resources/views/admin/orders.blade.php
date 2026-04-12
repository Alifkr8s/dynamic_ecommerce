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

<table class="table table-bordered">

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

@foreach($orders as $order)

<tr>
<td>{{ $order->user->name }}</td>
<td>{{ $order->deal->product_name }}</td>
<td>${{ $order->amount }}</td>
<td>{{ $order->payment_status }}</td>

<td>

@if($order->payment_status == 'pending')

<form action="{{ route('admin.approve',$order->id) }}" method="POST">
@csrf
<button class="btn btn-success btn-sm">
Approve Payment
</button>
</form>

@else

<span class="badge bg-success">Paid</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</body>
</html>