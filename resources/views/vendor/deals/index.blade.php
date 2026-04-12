<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Deals — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; margin: 0; }
        h1, h2, h3, h4, h5 { font-family: 'Syne', sans-serif; }
        .page-header { padding: 2.5rem 0 1.5rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
        .page-header h1 { font-size: 2rem; font-weight: 800; }
        .btn-primary-custom { background: var(--primary); border: none; font-family: 'Syne', sans-serif; font-weight: 600; padding: 0.6rem 1.4rem; border-radius: 8px; color: #fff; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-primary-custom:hover { background: #e55a1f; color: #fff; }
        .deal-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem; transition: border-color 0.2s; }
        .deal-card:hover { border-color: var(--primary); }
        .deal-card.cancelled { opacity: 0.7; border-color: #3a0000; }
        .deal-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; }
        .deal-product { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem; }
        .badge-status { padding: 0.35rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; font-family: 'Syne', sans-serif; }
        .badge-pending   { background: #2a2a00; color: #ffc107; }
        .badge-active    { background: #002a1a; color: #28a745; }
        .badge-cancelled { background: #2a0000; color: #dc3545; }
        .badge-completed { background: #00102a; color: #0d6efd; }
        .stat-box { background: #111; border: 1px solid var(--border); border-radius: 8px; padding: 0.6rem 1rem; text-align: center; min-width: 80px; }
        .stat-box .val { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; color: var(--primary); }
        .stat-box .lbl { font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
        .tier-pill { display: inline-block; background: #111; border: 1px solid var(--border); border-radius: 6px; padding: 0.3rem 0.7rem; font-size: 0.78rem; margin: 0.2rem; }
        .tier-pill span { color: var(--primary); font-weight: 600; }
        .action-btn { background: transparent; border: 1px solid var(--border); color: #ccc; border-radius: 7px; padding: 0.3rem 0.8rem; font-size: 0.82rem; transition: all 0.2s; text-decoration: none; display: inline-block; cursor: pointer; font-family: 'DM Sans', sans-serif; }
        .action-btn:hover { border-color: var(--primary); color: var(--primary); }
        .action-btn.danger:hover { border-color: #dc3545; color: #dc3545; }
        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--text-muted); }
        .deadline-text { font-size: 0.82rem; color: var(--text-muted); }
        .deadline-text.urgent { color: #ffc107; }
        .deadline-text.expired { color: #dc3545; }

        /* Alert styles */
        .alert-success-custom {
            background: #002a1a; border: 1px solid #28a745; color: #28a745;
            border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;
            display: flex; justify-content: space-between; align-items: center;
            font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.92rem;
        }
        .alert-error-custom {
            background: #2a0000; border: 1px solid #dc3545; color: #dc3545;
            border-radius: 10px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;
            font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.92rem;
        }

        /* Notification panel */
        .notif-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .notif-panel h6 {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.8rem;
        }
        .notif-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.85rem;
            gap: 1rem;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item .notif-msg { color: #ccc; flex: 1; line-height: 1.5; }
        .notif-item .notif-type { font-size: 0.75rem; color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 600; white-space: nowrap; }
        .notif-mark-read {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-muted);
            border-radius: 5px;
            padding: 0.15rem 0.5rem;
            font-size: 0.72rem;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }
        .notif-mark-read:hover { border-color: var(--primary); color: var(--primary); }

        /* Cancelled reason box */
        .cancelled-reason {
            background: #1a0000;
            border: 1px solid #3a0000;
            border-radius: 8px;
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Progress bar */
        .progress-mini { height: 4px; background: var(--border); border-radius: 2px; overflow: hidden; margin-top: 0.5rem; }
        .progress-mini-fill { height: 100%; background: var(--primary); border-radius: 2px; }
    </style>
</head>
<body>
@include('vendor.partials.navbar')

<div class="container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>My Deals</h1>
            <p style="color: var(--text-muted); margin:0;">Manage your group buying deals</p>
        </div>
        <a href="{{ route('vendor.deals.create') }}" class="btn-primary-custom">+ Create New Deal</a>
    </div>

    {{-- Success / Error Alerts --}}
    @if(session('success'))
        <div class="alert-success-custom" id="successAlert">
            <span>{{ session('success') }}</span>
            <span onclick="document.getElementById('successAlert').remove()"
                  style="cursor:pointer; margin-left:1rem;">✕</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error-custom">{{ session('error') }}</div>
    @endif

    {{-- Unread Notifications --}}
    @if(isset($notifications) && $notifications->count() > 0)
        <div class="notif-panel">
            <h6>🔔 Notifications ({{ $notifications->count() }} unread)</h6>
            @foreach($notifications as $notif)
                <div class="notif-item">
                    <div>
                        <div class="notif-type">
                            @if($notif->type === 'deal_cancelled') 🚫 Deal Cancelled
                            @elseif($notif->type === 'deal_activated') ✅ Deal Activated
                            @else 📢 {{ ucfirst(str_replace('_', ' ', $notif->type)) }}
                            @endif
                        </div>
                        <div class="notif-msg">{{ $notif->message }}</div>
                    </div>
                    <form method="POST" action="{{ route('vendor.notifications.read', $notif->id) }}">
                        @csrf
                        <button type="submit" class="notif-mark-read">Mark read</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Deals List --}}
    @if($deals->isEmpty())
        <div class="empty-state">
            <div style="font-size:3rem; margin-bottom:1rem;">🏷️</div>
            <h4>No deals yet</h4>
            <p>Create your first group buying deal to get started.</p>
            <a href="{{ route('vendor.deals.create') }}" class="btn-primary-custom">Create Deal</a>
        </div>
    @else
        {{-- Summary Stats --}}
        @php
            $totalDeals     = $deals->count();
            $activeDeals    = $deals->where('status', 'active')->count();
            $pendingDeals   = $deals->where('status', 'pending')->count();
            $cancelledDeals = $deals->where('status', 'cancelled')->count();
        @endphp
        <div class="d-flex gap-3 flex-wrap mb-4">
            <div class="stat-box">
                <div class="val">{{ $totalDeals }}</div>
                <div class="lbl">Total</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color:#28a745;">{{ $activeDeals }}</div>
                <div class="lbl">Active</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color:#ffc107;">{{ $pendingDeals }}</div>
                <div class="lbl">Pending</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color:#dc3545;">{{ $cancelledDeals }}</div>
                <div class="lbl">Cancelled</div>
            </div>
        </div>

        @foreach($deals as $deal)
        <div class="deal-card {{ $deal->status === 'cancelled' ? 'cancelled' : '' }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div style="flex:1;">
                    {{-- Title + Status --}}
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <div class="deal-title">{{ $deal->title }}</div>
                        <span class="badge-status badge-{{ $deal->status }}">{{ ucfirst($deal->status) }}</span>
                    </div>
                    <div class="deal-product">📦 {{ $deal->product->name ?? 'N/A' }}</div>

                    {{-- Stats --}}
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <div class="stat-box">
                            <div class="val">{{ $deal->current_participants }}</div>
                            <div class="lbl">Joined</div>
                        </div>
                        <div class="stat-box">
                            <div class="val">{{ $deal->min_participants }}</div>
                            <div class="lbl">Min Required</div>
                        </div>
                        <div class="stat-box">
                            <div class="val">৳{{ number_format($deal->current_price, 0) }}</div>
                            <div class="lbl">Current Price</div>
                        </div>
                        <div class="stat-box">
                            <div class="val">{{ $deal->tiers->count() }}</div>
                            <div class="lbl">Tiers</div>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    @if($deal->status !== 'cancelled')
                        @php $pct = min(100, ($deal->current_participants / $deal->min_participants) * 100); @endphp
                        <div class="progress-mini mb-2">
                            <div class="progress-mini-fill" style="width: {{ $pct }}%;"></div>
                        </div>
                    @endif

                    {{-- Tiers --}}
                    <div class="mb-2">
                        @foreach($deal->tiers->sortBy('min_count') as $tier)
                            <span class="tier-pill">{{ $tier->min_count }}+ people → <span>৳{{ number_format($tier->price, 0) }}</span></span>
                        @endforeach
                    </div>

                    {{-- Deadline --}}
                    @if($deal->status === 'cancelled')
                        <div class="cancelled-reason">
                            🚫 This deal was automatically cancelled — minimum participants not reached before deadline.
                        </div>
                    @else
                        <div class="deadline-text
                            {{ $deal->isExpired() ? 'expired' : ($deal->deadline->diffInHours(now()) < 24 ? 'urgent' : '') }}">
                            ⏰ Deadline: {{ $deal->deadline->format('d M Y, h:i A') }}
                            ({{ $deal->deadline->diffForHumans() }})
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="d-flex flex-column gap-2" style="min-width: 70px;">
                    @if($deal->status !== 'cancelled')
                        <a href="{{ route('vendor.deals.show', $deal->id) }}" class="action-btn">View</a>
                    @endif
                    @if($deal->status === 'pending')
                        <a href="{{ route('vendor.deals.edit', $deal->id) }}" class="action-btn">Edit</a>
                        <form method="POST" action="{{ route('vendor.deals.destroy', $deal->id) }}"
                              onsubmit="return confirm('Cancel and delete this deal?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" style="width:100%;">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-refresh page every 60 seconds to catch newly cancelled deals
    setTimeout(function () {
        location.reload();
    }, 60000);
</script>
</body>
</html>