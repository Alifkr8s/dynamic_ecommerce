<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $deal->title }} — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b2b;
            --dark: #0f0f0f;
            --card-bg: #1a1a1a;
            --border: #2a2a2a;
            --text-muted: #888;
            --green: #28a745;
            --red: #dc3545;
            --yellow: #ffc107;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Syne', sans-serif; }

        .info-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.8rem;
            margin-bottom: 1.2rem;
            position: relative;
            overflow: hidden;
        }
        .info-card .card-label {
            font-size: 0.75rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--primary);
            margin-bottom: 1.2rem;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .lbl { color: var(--text-muted); }

        /* Status badge */
        .badge-status { padding: 0.35rem 0.9rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700; font-family: 'Syne', sans-serif; }
        .badge-pending   { background: #2a2a00; color: var(--yellow); }
        .badge-active    { background: #002a1a; color: var(--green); }
        .badge-cancelled { background: #2a0000; color: var(--red); }
        .badge-completed { background: #00102a; color: #0d6efd; }

        /* ── COUNTDOWN ── */
        .countdown-section {
            background: #111;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.2rem;
            position: relative;
            overflow: hidden;
        }
        .countdown-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #ff9a5c);
        }
        .countdown-section .cd-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }
        .countdown-grid {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .cd-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 70px;
        }
        .cd-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 2.8rem;
            font-weight: 700;
            color: #fff;
            background: #1a1a1a;
            border: 1px solid var(--border);
            border-radius: 10px;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
            position: relative;
            overflow: hidden;
        }
        .cd-number.urgent { color: var(--red); border-color: #3a0000; animation: pulse 1s infinite; }
        .cd-number.warning { color: var(--yellow); }
        .cd-number.normal { color: var(--primary); }
        .cd-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        .cd-separator {
            font-size: 2rem;
            color: var(--border);
            align-self: center;
            margin-bottom: 1.5rem;
            font-family: 'JetBrains Mono', monospace;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .expired-banner {
            background: #2a0000;
            border: 1px solid var(--red);
            border-radius: 10px;
            padding: 1rem;
            color: var(--red);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .deadline-display {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        .deadline-display span { color: #ccc; }

        /* ── PARTICIPANT TRACKER ── */
        .tracker-section {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.8rem;
            margin-bottom: 1.2rem;
        }
        .tracker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .tracker-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--primary);
        }
        .live-badge {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: var(--green);
            background: rgba(40,167,69,0.1);
            border: 1px solid rgba(40,167,69,0.2);
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
        }
        .live-dot {
            width: 7px; height: 7px;
            background: var(--green);
            border-radius: 50%;
            animation: livePulse 1.5s infinite;
        }
        @keyframes livePulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* Big participant counter */
        .participant-counter {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .participant-big {
            font-family: 'JetBrains Mono', monospace;
            font-size: 4rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            transition: all 0.3s;
        }
        .participant-big.bump {
            transform: scale(1.15);
            color: var(--green);
        }
        .participant-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }
        .participant-sub span { color: #fff; font-weight: 600; }

        /* Progress bar */
        .progress-outer {
            background: #111;
            border: 1px solid var(--border);
            border-radius: 10px;
            height: 14px;
            overflow: hidden;
            margin-bottom: 0.5rem;
            position: relative;
        }
        .progress-inner {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), #ff9a5c);
            border-radius: 10px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .progress-inner::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 20px; height: 100%;
            background: rgba(255,255,255,0.3);
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }
        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        /* Slots remaining */
        .slots-box {
            background: #111;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.9rem 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .slots-box .slots-label { font-size: 0.85rem; color: var(--text-muted); }
        .slots-box .slots-val {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--yellow);
        }
        .slots-box.goal-reached .slots-val { color: var(--green); }

        /* Next tier box */
        .next-tier-box {
            background: rgba(255,107,43,0.06);
            border: 1px solid rgba(255,107,43,0.2);
            border-radius: 10px;
            padding: 0.9rem 1.2rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }
        .next-tier-box .nt-label { color: var(--text-muted); margin-bottom: 0.3rem; font-size: 0.78rem; font-family: 'Syne', sans-serif; text-transform: uppercase; letter-spacing: 0.08em; }
        .next-tier-box .nt-val { color: var(--primary); font-weight: 700; font-family: 'Syne', sans-serif; font-size: 1rem; }

        /* Recent participants */
        .recent-list { margin-top: 1rem; }
        .recent-title {
            font-size: 0.75rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.6rem;
        }
        .recent-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.45rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.83rem;
            animation: fadeInUp 0.4s ease;
        }
        .recent-item:last-child { border-bottom: none; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .recent-avatar {
            width: 28px; height: 28px;
            background: rgba(255,107,43,0.15);
            border: 1px solid rgba(255,107,43,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: var(--primary);
            flex-shrink: 0;
        }
        .recent-name { color: #ccc; flex: 1; }
        .recent-time { color: var(--text-muted); font-size: 0.75rem; }

        /* Tier list */
        .tier-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #111;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.8rem 1.2rem;
            margin-bottom: 0.6rem;
            transition: border-color 0.3s;
        }
        .tier-item.active-tier {
            border-color: var(--primary);
            background: rgba(255,107,43,0.05);
        }
        .tier-item .tier-price {
            color: var(--primary);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
        }
        .tier-item .tier-active-tag {
            font-size: 0.7rem;
            background: rgba(255,107,43,0.15);
            color: var(--primary);
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
        }

        /* Action btn */
        .action-btn {
            background: transparent;
            border: 1px solid var(--border);
            color: #ccc;
            border-radius: 7px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
        }
        .action-btn:hover { border-color: var(--primary); color: var(--primary); }

        /* Status changed toast */
        .status-toast {
            position: fixed;
            top: 80px;
            right: 20px;
            background: #2a0000;
            border: 1px solid var(--red);
            color: var(--red);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            z-index: 9999;
            display: none;
            animation: slideIn 0.3s ease;
        }
        .status-toast.show { display: block; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Update indicator */
        .update-indicator {
            font-size: 0.72rem;
            color: var(--text-muted);
            text-align: right;
            margin-top: 0.5rem;
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body>
@include('vendor.partials.navbar')

{{-- Status Change Toast --}}
<div class="status-toast" id="statusToast">
    🚫 This deal has been automatically cancelled!
</div>

<div class="container" style="max-width: 820px; padding: 2rem 1rem 4rem;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <div style="color: var(--text-muted); font-size:0.82rem; margin-bottom:0.4rem;">
                <a href="{{ route('vendor.deals.index') }}" style="color:var(--text-muted); text-decoration:none;">My Deals</a>
                → {{ $deal->title }}
            </div>
            <h1 style="font-size:1.8rem; margin-bottom:0.5rem;">{{ $deal->title }}</h1>
            <span class="badge-status badge-{{ $deal->status }}" id="statusBadge">
                {{ ucfirst($deal->status) }}
            </span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            @if($deal->status === 'pending')
                <a href="{{ route('vendor.deals.edit', $deal->id) }}" class="action-btn">Edit Deal</a>
            @endif
            <a href="{{ route('vendor.deals.index') }}" class="action-btn">← Back</a>
        </div>
    </div>

    {{-- COUNTDOWN TIMER --}}
    @if($deal->status !== 'cancelled' && $deal->status !== 'completed')
        <div class="countdown-section" id="countdownSection">
            <div class="cd-title">⏰ Time Remaining Until Deadline</div>

            <div class="countdown-grid" id="countdownGrid">
                <div class="cd-unit">
                    <div class="cd-number normal" id="cd-days">00</div>
                    <div class="cd-label">Days</div>
                </div>
                <div class="cd-separator">:</div>
                <div class="cd-unit">
                    <div class="cd-number normal" id="cd-hours">00</div>
                    <div class="cd-label">Hours</div>
                </div>
                <div class="cd-separator">:</div>
                <div class="cd-unit">
                    <div class="cd-number normal" id="cd-minutes">00</div>
                    <div class="cd-label">Minutes</div>
                </div>
                <div class="cd-separator">:</div>
                <div class="cd-unit">
                    <div class="cd-number normal" id="cd-seconds">00</div>
                    <div class="cd-label">Seconds</div>
                </div>
            </div>

            <div class="deadline-display">
                Deadline: <span>{{ $deal->deadline->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    @else
        <div class="expired-banner">
            🚫 This deal has ended —
            @if($deal->status === 'cancelled') automatically cancelled due to insufficient participants.
            @else completed successfully!
            @endif
        </div>
    @endif

    <div class="row g-3">
        {{-- LEFT: Participant Tracker --}}
        <div class="col-lg-7">
            <div class="tracker-section">
                <div class="tracker-header">
                    <div class="tracker-title">👥 Participant Tracker</div>
                    @if($deal->status !== 'cancelled' && $deal->status !== 'completed')
                        <div class="live-badge">
                            <div class="live-dot"></div>
                            LIVE
                        </div>
                    @endif
                </div>

                {{-- Big Counter --}}
                <div class="participant-counter">
                    <div class="participant-big" id="participantCount">
                        {{ $deal->current_participants }}
                    </div>
                    <div class="participant-sub">
                        out of <span>{{ $deal->min_participants }}</span> minimum required
                    </div>
                </div>

                {{-- Progress Bar --}}
                @php $initPct = min(100, round(($deal->current_participants / $deal->min_participants) * 100)); @endphp
                <div class="progress-outer">
                    <div class="progress-inner" id="progressBar" style="width: {{ $initPct }}%;"></div>
                </div>
                <div class="progress-labels">
                    <span id="progressLabel">{{ $initPct }}% filled</span>
                    <span id="slotsLabel">{{ max(0, $deal->min_participants - $deal->current_participants) }} slots remaining</span>
                </div>

                {{-- Slots box --}}
                <div class="slots-box {{ $deal->isGoalReached() ? 'goal-reached' : '' }}" id="slotsBox">
                    <span class="slots-label">
                        {{ $deal->isGoalReached() ? '🎉 Minimum reached! Deal will activate.' : '⏳ Slots still needed' }}
                    </span>
                    <span class="slots-val" id="slotsVal">
                        {{ $deal->isGoalReached() ? '✓ Goal Met' : max(0, $deal->min_participants - $deal->current_participants) . ' more' }}
                    </span>
                </div>

                {{-- Next tier --}}
                <div class="next-tier-box" id="nextTierBox">
                    <div class="nt-label">Next Price Tier</div>
                    <div class="nt-val" id="nextTierVal">Loading...</div>
                </div>

                {{-- Recent participants --}}
                <div class="recent-list">
                    <div class="recent-title">Recent Participants</div>
                    <div id="recentList">
                        @forelse($deal->participants->sortByDesc('joined_at')->take(5) as $p)
                            <div class="recent-item">
                                <div class="recent-avatar">{{ strtoupper(substr($p->user->name ?? 'A', 0, 1)) }}</div>
                                <div class="recent-name">{{ $p->user->name ?? 'Anonymous' }}</div>
                                <div class="recent-time">{{ \Carbon\Carbon::parse($p->joined_at)->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div style="color: var(--text-muted); font-size:0.85rem; text-align:center; padding:1rem;">
                                No participants yet
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="update-indicator" id="updateIndicator">
                    Last updated: just now
                </div>
            </div>
        </div>

        {{-- RIGHT: Deal Info + Tiers --}}
        <div class="col-lg-5">

            {{-- Deal Info --}}
            <div class="info-card">
                <div class="card-label">📋 Deal Details</div>
                <div class="info-row">
                    <span class="lbl">Product</span>
                    <span>{{ $deal->product->name }}</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Description</span>
                    <span style="text-align:right; max-width:60%;">{{ $deal->description ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Current Price</span>
                    <span style="color:var(--primary); font-family:'Syne',sans-serif; font-weight:700;" id="currentPriceDisplay">
                        ৳{{ number_format($deal->current_price, 0) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="lbl">Status</span>
                    <span id="statusText">{{ ucfirst($deal->status) }}</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Created</span>
                    <span>{{ $deal->created_at->format('d M Y') }}</span>
                </div>
            </div>

            {{-- Pricing Tiers --}}
            <div class="info-card">
                <div class="card-label">💰 Pricing Tiers</div>
                <div id="tiersList">
                    @foreach($deal->tiers->sortBy('min_count') as $tier)
                        <div class="tier-item {{ $deal->current_participants >= $tier->min_count ? 'active-tier' : '' }}"
                             id="tier-{{ $tier->min_count }}">
                            <div>
                                <div style="font-size:0.85rem; color:#ccc;">{{ $tier->min_count }}+ participants</div>
                                @if($deal->current_participants >= $tier->min_count)
                                    <span class="tier-active-tag">✓ Current</span>
                                @endif
                            </div>
                            <span class="tier-price">৳{{ number_format($tier->price, 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const DEAL_ID       = {{ $deal->id }};
    const API_URL       = '/api/deals/' + DEAL_ID + '/status';
    const DEADLINE      = new Date('{{ $deal->deadline->toISOString() }}');
    const INITIAL_STATUS = '{{ $deal->status }}';

    let lastParticipantCount = {{ $deal->current_participants }};
    let currentStatus        = INITIAL_STATUS;
    let countdownInterval    = null;
    let pollInterval         = null;

    // ── COUNTDOWN TIMER ──
    function updateCountdown() {
        const now       = new Date();
        const diff      = DEADLINE - now;

        if (diff <= 0) {
            // Expired
            document.getElementById('cd-days').textContent    = '00';
            document.getElementById('cd-hours').textContent   = '00';
            document.getElementById('cd-minutes').textContent = '00';
            document.getElementById('cd-seconds').textContent = '00';
            clearInterval(countdownInterval);
            return;
        }

        const days    = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('cd-days').textContent    = String(days).padStart(2, '0');
        document.getElementById('cd-hours').textContent   = String(hours).padStart(2, '0');
        document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');

        // Color urgency
        const totalHours = diff / (1000 * 60 * 60);
        const urgencyClass = totalHours < 1 ? 'urgent' : totalHours < 24 ? 'warning' : 'normal';
        ['cd-days','cd-hours','cd-minutes','cd-seconds'].forEach(id => {
            const el = document.getElementById(id);
            el.className = 'cd-number ' + urgencyClass;
        });
    }

    // ── REAL-TIME POLL ──
    async function pollDealStatus() {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) return;
            const data = await response.json();

            // Update participant count with animation
            const countEl = document.getElementById('participantCount');
            if (data.current_participants !== lastParticipantCount) {
                countEl.classList.add('bump');
                setTimeout(() => countEl.classList.remove('bump'), 400);
                lastParticipantCount = data.current_participants;
            }
            countEl.textContent = data.current_participants;

            // Update progress bar
            document.getElementById('progressBar').style.width = data.progress_percent + '%';
            document.getElementById('progressLabel').textContent = data.progress_percent + '% filled';
            document.getElementById('slotsLabel').textContent = data.remaining_slots + ' slots remaining';

            // Update current price
            document.getElementById('currentPriceDisplay').textContent =
                '৳' + parseFloat(data.current_price).toLocaleString();

            // Update slots box
            const slotsBox = document.getElementById('slotsBox');
            const slotsVal = document.getElementById('slotsVal');
            if (data.is_goal_reached) {
                slotsBox.classList.add('goal-reached');
                slotsBox.querySelector('.slots-label').textContent = '🎉 Minimum reached! Deal will activate.';
                slotsVal.textContent = '✓ Goal Met';
            } else {
                slotsBox.classList.remove('goal-reached');
                slotsBox.querySelector('.slots-label').textContent = '⏳ Slots still needed';
                slotsVal.textContent = data.remaining_slots + ' more';
            }

            // Update next tier
            const nextTierVal = document.getElementById('nextTierVal');
            if (data.next_tier) {
                nextTierVal.textContent =
                    data.next_tier.slots_needed + ' more needed → ৳' +
                    parseFloat(data.next_tier.price).toLocaleString();
            } else {
                nextTierVal.textContent = '🎉 All tiers unlocked!';
                nextTierVal.style.color = '#28a745';
            }

            // Update recent participants
            if (data.recent_participants && data.recent_participants.length > 0) {
                const recentList = document.getElementById('recentList');
                recentList.innerHTML = data.recent_participants.map(p => `
                    <div class="recent-item">
                        <div class="recent-avatar">${p.name.charAt(0).toUpperCase()}</div>
                        <div class="recent-name">${p.name}</div>
                        <div class="recent-time">${p.joined_at}</div>
                    </div>
                `).join('');
            }

            // Update tier highlights
            document.querySelectorAll('.tier-item').forEach(el => {
                el.classList.remove('active-tier');
                const minCount = parseInt(el.id.replace('tier-', ''));
                if (data.current_participants >= minCount) {
                    el.classList.add('active-tier');
                }
            });

            // Check if status changed
            if (data.status !== currentStatus) {
                currentStatus = data.status;

                // Update badge
                const badge = document.getElementById('statusBadge');
                badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                badge.className = 'badge-status badge-' + data.status;

                document.getElementById('statusText').textContent =
                    data.status.charAt(0).toUpperCase() + data.status.slice(1);

                // Show toast if cancelled
                if (data.status === 'cancelled') {
                    const toast = document.getElementById('statusToast');
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 5000);

                    // Hide countdown
                    const cdSection = document.getElementById('countdownSection');
                    if (cdSection) cdSection.style.display = 'none';

                    clearInterval(pollInterval);
                    clearInterval(countdownInterval);
                }
            }

            // Update timestamp
            const now = new Date();
            document.getElementById('updateIndicator').textContent =
                'Last updated: ' + now.toLocaleTimeString();

        } catch (err) {
            console.error('Poll error:', err);
        }
    }

    // ── INIT ──
    if (INITIAL_STATUS !== 'cancelled' && INITIAL_STATUS !== 'completed') {
        // Start countdown
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);

        // Initial next tier load
        pollDealStatus();

        // Poll every 5 seconds for real-time updates
        pollInterval = setInterval(pollDealStatus, 5000);
    }
</script>
</body>
</html>