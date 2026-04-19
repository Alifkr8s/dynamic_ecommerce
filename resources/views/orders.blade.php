<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">

<h2>My Orders</h2>

<!-- SUCCESS -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- ERROR -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Deal</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)
    <tr>
        <td>{{ $order->deal_id }}</td>
        <td>${{ $order->amount }}</td>

        <td>
            @if($order->status == 'approved')
                <span class="badge bg-info">Approved</span>
            @elseif($order->status == 'completed')
                <span class="badge bg-success">Completed</span>
            @else
                <span class="badge bg-warning">{{ $order->status }}</span>
            @endif
        </td>

        <td>
            @if($order->payment_status == 'paid')
                <span class="badge bg-success">Paid</span>
            @else
                <span class="badge bg-danger">Unpaid</span>
            @endif
        </td>

        <td>
            @if($order->status == 'approved' && $order->payment_status == 'unpaid')
                
                <!-- 🔥 FINAL WORKING FORM -->
                <form method="POST" action="/payment/request">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-success btn-sm">
                        Pay Now
                    </button>
                </form>

            @elseif($order->payment_status == 'paid')
                <span class="text-success">✔ Paid</span>
            @else
                -
            @endif
        </td>

    </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No orders found</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>