<!DOCTYPE html>
<html>

<head>
    <title>Admin Orders Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Admin Orders Dashboard</h2>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
        <tr>
            <th>User</th>
            <th>Email</th>
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

                <td>{{ $order->user_name }}</td>
                <td>{{ $order->user_email }}</td>
                <td>{{ $order->deal_id }}</td>
                <td>${{ $order->amount }}</td>

                <!-- ORDER STATUS -->
                <td>
                    @if($order->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($order->status == 'approved')
                        <span class="badge bg-info">Approved</span>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                    @endif
                </td>

                <!-- PAYMENT STATUS -->
                <td>
                    @if($order->payment_status == 'unpaid')
                        <span class="badge bg-danger">Unpaid</span>
                    @else
                        <span class="badge bg-success">Paid</span>
                    @endif
                </td>

                <!-- ACTIONS -->
                <td>

                    <!-- APPROVE BUTTON -->
                    @if($order->status == 'pending')
                        <form method="POST" action="{{ route('admin.approve', $order->id) }}">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                Approve
                            </button>
                        </form>
                    @endif

                    <!-- WAITING -->
                    @if($order->status == 'approved' && $order->payment_status == 'unpaid')
                        <p class="text-warning mt-2">Waiting for Payment</p>
                    @endif

                    <!-- PAYMENT DONE -->
                    @if($order->payment_status == 'paid')
                        <p class="text-success mt-2">✅ Paid</p>
                    @endif

                    <!-- BILL -->
                    <a href="/admin/bill/{{ $order->id }}" class="btn btn-primary btn-sm mt-1">
                        Generate Bill
                    </a>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center">
                    No orders found
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>