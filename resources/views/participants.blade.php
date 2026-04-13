<!DOCTYPE html>
<html lang="en">
<head>
    <title>Participants | GroupBuy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #e4ecf7);
        }

        .card {
            border-radius: 15px;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .badge {
            font-size: 0.9rem;
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
            <h2 class="fw-bold text-primary">👥 Participants Overview</h2>
            <p class="text-muted">
                Real-time users who joined deals
            </p>

            <span class="badge bg-success">
                Total Participants: {{ count($participants) }}
            </span>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow">
        <div class="card-body">

            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>👤 Name</th>
                        <th>📧 Email</th>
                        <th>🎯 Deal ID</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($participants as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-primary">
                                Deal #{{ $user->deal_id }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">Joined</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">No participants found</td>
                    </tr>
                @endforelse

                </tbody>
            </table>

        </div>
    </div>

    <!-- BACK BUTTON -->
    <div class="text-center mt-4">
        <a href="/dashboard" class="btn btn-dark">
            ⬅ Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>