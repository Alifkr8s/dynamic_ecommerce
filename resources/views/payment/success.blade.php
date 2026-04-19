<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; --green: #28a745; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }
        h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

        .success-card { background: var(--card-bg); border: 1px solid #1a3a1a; border-radius: 20px; padding: 3rem 2.5rem; max-width: 560px; width: 100%; text-align: center; position: relative; overflow: hidden; }
        .success-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--green), #5cb85c); }

        .success-icon { width: 80px; height: 80px; background: rgba(40,167,69,0.1); border: 2px solid rgba(40,167,69,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.2rem; animation: popIn 0.5s ease; }
        @keyframes popIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .success-title { font-size: 1.8rem; font-weight: 800; color: var(--green); margin-bottom: 0.5rem; }
        .success-sub { color: var(--text-muted); font-size: 0.92rem; margin-bottom: 2rem; }

        .invoice-box { background: #111; border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; text-align: left; }
        .invoice-row { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border); font-size: 0.88rem; }
        .invoice-row:last-child { border-bottom: none; }
        .invoice-row .lbl { color: var(--text-muted); }
        .invoice-row .val { font-weight: 500; }
        .invoice-number { font-family: 'JetBrains Mono', monospace; color: var(--primary); }

        .amount-display { font-family: 'JetBrains Mono', monospace; font-size: 2rem; font-weight: 700; color: var(--green); }

        .btn-home { display: inline-block; background: var(--primary); color: #fff; font-family: 'Syne', sans-serif; font-weight: 700; padding: 0.75rem 2rem; border-radius: 10px; text-decoration: none; margin-top: 1rem; transition: background 0.2s; }
        .btn-home:hover { background: #e55a1f; color: #fff; }
        .btn-outline-custom { display: inline-block; background: transparent; color: #ccc; font-family: 'Syne', sans-serif; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; border: 1px solid var(--border); margin-top: 1rem; transition: all 0.2s; }
        .btn-outline-custom:hover { border-color: var(--primary); color: var(--primary); }

        .hold-notice { background: rgba(255,193,7,0.08); border: 1px solid rgba(255,193,7,0.2); border-radius: 10px; padding: 1rem; font-size: 0.82rem; color: #aaa; margin-bottom: 1.5rem; text-align: left; }
        .hold-notice strong { color: #ffc107; }
    </style>
</head>
<body>
<div class="success-card">
    <div class="success-icon">✅</div>
    <div class="success-title">Payment Successful!</div>
    <div class="success-sub">You have successfully joined the deal. Your payment is held securely.</div>

    {{-- Invoice --}}
    <div class="invoice-box">
        <div style="font-size:0.72rem; font-family:'Syne',sans-serif; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:var(--primary); margin-bottom:0.8rem;">📄 Invoice</div>
        <div class="invoice-row">
            <span class="lbl">Invoice No.</span>
            <span class="val invoice-number">{{ $order->invoice->invoice_number ?? 'N/A' }}</span>
        </div>
        <div class="invoice-row">
            <span class="lbl">Deal</span>
            <span class="val">{{ $order->deal->title }}</span>
        </div>
        <div class="invoice-row">
            <span class="lbl">Product</span>
            <span class="val">{{ $order->deal->product->name }}</span>
        </div>
        <div class="invoice-row">
            <span class="lbl">Order ID</span>
            <span class="val">#{{ $order->id }}</span>
        </div>
        <div class="invoice-row">
            <span class="lbl">Payment ID</span>
            <span class="val" style="font-family:'JetBrains Mono',monospace; font-size:0.78rem;">{{ $order->payment->stripe_payment_id ?? 'N/A' }}</span>
        </div>
        <div class="invoice-row">
            <span class="lbl">Status</span>
            <span class="val" style="color:var(--green);">✓ Paid</span>
        </div>
        <div class="invoice-row" style="border-top: 1px solid var(--border); margin-top:0.5rem; padding-top:0.8rem;">
            <span class="lbl" style="font-family:'Syne',sans-serif; font-weight:700;">Total Paid</span>
            <span class="amount-display">${{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    {{-- Hold notice --}}
    <div class="hold-notice">
        ⏳ <strong>Payment on Hold:</strong> Your payment is securely held by TierMart admin.
        Once the deal reaches <strong>{{ $order->deal->min_participants }} participants</strong>,
        it will be confirmed and released to the vendor.
        If the deal fails, you will receive an <strong>automatic full refund</strong>.
    </div>

    <div class="d-flex gap-2 justify-content-center flex-wrap">
        <a href="{{ url('/deals') }}" class="btn-home">Browse More Deals</a>
        <a href="{{ url('/') }}" class="btn-outline-custom">← Home</a>
    </div>
</div>
</body>
</html>