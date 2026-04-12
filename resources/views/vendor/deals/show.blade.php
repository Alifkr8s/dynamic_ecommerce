<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deal Details — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; margin: 0; }
        h1, h2, h3, h4, h5 { font-family: 'Syne', sans-serif; }
        .info-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 1.8rem; margin-bottom: 1.2rem; }
        .info-card h5 { color: var(--primary); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.2rem; }
        .info-row { display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .info-row:last-child { border-bottom: none; }
        .info-row .lbl { color: var(--text-muted); }
        .badge-status { padding: 0.35rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-pending   { background: #2a2a00; color: #ffc107; }
        .badge-active    { background: #002a1a; color: #28a745; }
        .badge-cancelled { background: #2a0000; color: #dc3545; }
        .badge-completed { background: #00102a; color: #0d6efd; }
        .tier-item { display: flex; justify-content: space-between; align-items: center; background: #111; border: 1px solid var(--border); border-radius: 8px; padding: 0.8rem 1.2rem; margin-bottom: 0.6rem; }
        .tier-item .price { color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; }
        .progress-bar-custom { height: 8px; background: var(--border); border-radius: 4px; overflow: hidden; margin: 0.5rem 0; }
        .progress-fill { height: 100%; background: var(--primary); border-radius: 4px; }
        .action-btn { background: transparent; border: 1px solid var(--border); color: #ccc; border-radius: 7px; padding: 0.4rem 1rem; font-size: 0.85rem; text-decoration: none; display: inline-block; transition: all 0.2s; font-family: 'Syne', sans-serif; }
        .action-btn:hover { border-color: var(--primary); color: var(--primary); }
    </style>
</head>
<body>
@include('vendor.partials.navbar')

<div class="container" style="max-width: 750px; padding: 2rem 1rem 4rem;">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h1 style="font-size:1.8rem; margin-bottom:0.3rem;">{{ $deal->title }}</h1>
            <span class="badge-status badge-{{ $deal->status }}">{{ ucfirst($deal->status) }}</span>
        </div>
        @if($deal->status === 'pending')
            <a href="{{ route('vendor.deals.edit', $deal->id) }}" class="action-btn">Edit Deal</a>
        @endif
    </div>

    <div class="info-card">
        <h5>📋 Deal Details</h5>
        <div class="info-row"><span class="lbl">Product</span><span>{{ $deal->product->name }}</span></div>
        <div class="info-row"><span class="lbl">Description</span><span>{{ $deal->description ?? '—' }}</span></div>
        <div class="info-row"><span class="lbl">Current Price</span><span style="color:var(--primary);">৳{{ number_format($deal->current_price, 2) }}</span></div>
        <div class="info-row"><span class="lbl">Deadline</span><span>{{ \Carbon\Carbon::parse($deal->deadline)->format('d M Y, h:i A') }}</span></div>
        <div class="info-row"><span class="lbl">Time Remaining</span><span>{{ \Carbon\Carbon::parse($deal->deadline)->diffForHumans() }}</span></div>
        <div class="info-row"><span class="lbl">Created</span><span>{{ $deal->created_at->format('d M Y') }}</span></div>
    </div>

    <div class="info-card">
        <h5>👥 Participant Progress</h5>
        @php $pct = min(100, ($deal->current_participants / $deal->min_participants) * 100); @endphp
        <div class="d-flex justify-content-between mb-1" style="font-size:0.88rem;">
            <span style="color:var(--text-muted);">{{ $deal->current_participants }} joined</span>
            <span style="color:var(--text-muted);">{{ $deal->min_participants }} needed</span>
        </div>
        <div class="progress-bar-custom">
            <div class="progress-fill" style="width: {{ $pct }}%;"></div>
        </div>
        <div style="font-size:0.82rem; color:var(--text-muted); margin-top:0.4rem;">
            {{ $deal->remainingSlots() }} more participants needed to activate
        </div>
    </div>

    <div class="info-card">
        <h5>💰 Pricing Tiers</h5>
        @foreach($deal->tiers->sortBy('min_count') as $tier)
            <div class="tier-item">
                <span style="color:var(--text-muted); font-size:0.88rem;">{{ $tier->min_count }}+ participants</span>
                <span class="price">৳{{ number_format($tier->price, 0) }}</span>
            </div>
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>