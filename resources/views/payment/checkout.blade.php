<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; --green: #28a745; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        h1,h2,h3,h4,h5 { font-family: 'Syne', sans-serif; }

        .navbar { background: rgba(17,17,17,0.95); border-bottom: 1px solid var(--border); padding: 1rem 0; }
        .navbar-brand { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.6rem; color: var(--primary) !important; text-decoration: none; }

        .checkout-wrapper { min-height: calc(100vh - 65px); display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }

        .checkout-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; max-width: 900px; width: 100%; }
        @media (max-width: 768px) { .checkout-grid { grid-template-columns: 1fr; } }

        .card-box { background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; position: relative; overflow: hidden; }
        .card-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--primary), #ff9a5c); }

        .section-label { font-size: 0.75rem; font-family: 'Syne', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--primary); margin-bottom: 1.2rem; }

        .deal-summary-row { display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .deal-summary-row:last-child { border-bottom: none; }
        .deal-summary-row .lbl { color: var(--text-muted); }

        .amount-box { background: #111; border: 1px solid var(--border); border-radius: 12px; padding: 1.2rem; text-align: center; margin: 1.5rem 0; }
        .amount-big { font-family: 'JetBrains Mono', monospace; font-size: 2.5rem; font-weight: 700; color: var(--primary); }
        .amount-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 0.3rem; }

        .tier-info { background: rgba(255,107,43,0.06); border: 1px solid rgba(255,107,43,0.15); border-radius: 8px; padding: 0.8rem 1rem; font-size: 0.82rem; color: #aaa; margin-bottom: 1rem; }

        /* Stripe form */
        .form-label-custom { font-family: 'Syne', sans-serif; font-size: 0.82rem; font-weight: 600; color: #ccc; margin-bottom: 0.4rem; display: block; }
        .stripe-input-wrapper { background: #111; border: 1px solid var(--border); border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 1rem; transition: border-color 0.2s; }
        .stripe-input-wrapper.focused { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,107,43,0.15); }
        .stripe-input-wrapper.error { border-color: #dc3545; }

        .input-custom { background: #111; border: 1px solid var(--border); color: #fff; border-radius: 8px; padding: 0.7rem 1rem; font-family: 'DM Sans', sans-serif; width: 100%; font-size: 0.92rem; margin-bottom: 1rem; }
        .input-custom:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,107,43,0.15); }
        .input-custom::placeholder { color: #555; }

        .btn-pay { width: 100%; background: var(--primary); color: #fff; border: none; border-radius: 10px; padding: 0.9rem; font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn-pay:hover:not(:disabled) { background: #e55a1f; transform: translateY(-1px); }
        .btn-pay:disabled { opacity: 0.6; cursor: not-allowed; }

        .security-note { display: flex; align-items: center; gap: 0.5rem; font-size: 0.78rem; color: var(--text-muted); margin-top: 0.8rem; justify-content: center; }

        .error-msg { background: #2a0000; border: 1px solid #dc3545; color: #dc3545; border-radius: 8px; padding: 0.7rem 1rem; font-size: 0.85rem; margin-bottom: 1rem; display: none; }

        .loading-spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .test-card-hint { background: #111; border: 1px solid var(--border); border-radius: 8px; padding: 0.8rem 1rem; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 1rem; }
        .test-card-hint strong { color: var(--primary); font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="navbar-brand">TierMart</a>
        <a href="{{ route('deals.browse') }}" style="color:var(--text-muted); text-decoration:none; font-size:0.88rem;">← Back to Deals</a>
    </div>
</nav>

<div class="checkout-wrapper">
    <div class="checkout-grid">

        {{-- LEFT: Deal Summary --}}
        <div class="card-box">
            <div class="section-label">🛒 Order Summary</div>

            <div class="deal-summary-row">
                <span class="lbl">Deal</span>
                <span style="text-align:right; max-width:60%;">{{ $deal->title }}</span>
            </div>
            <div class="deal-summary-row">
                <span class="lbl">Product</span>
                <span>{{ $deal->product->name }}</span>
            </div>
            <div class="deal-summary-row">
                <span class="lbl">Vendor</span>
                <span>{{ $deal->vendor->shop_name ?? 'N/A' }}</span>
            </div>
            <div class="deal-summary-row">
                <span class="lbl">Participants</span>
                <span>{{ $deal->current_participants }} / {{ $deal->min_participants }} min</span>
            </div>
            <div class="deal-summary-row">
                <span class="lbl">Deadline</span>
                <span>{{ $deal->deadline->format('d M Y, h:i A') }}</span>
            </div>
            <div class="deal-summary-row">
                <span class="lbl">Status</span>
                <span style="color: {{ $deal->status === 'active' ? '#28a745' : '#ffc107' }};">{{ ucfirst($deal->status) }}</span>
            </div>

            <div class="amount-box">
                <div class="amount-big">${{ number_format($deal->current_price, 2) }}</div>
                <div class="amount-label">Current deal price (USD)</div>
            </div>

            <div class="tier-info">
                💡 <strong>How pricing works:</strong> Your payment will be held securely. Once the deal reaches
                <strong>{{ $deal->min_participants }} participants</strong>, it activates and your order is confirmed.
                If the deal fails, you get a full automatic refund.
            </div>

            {{-- Tiers --}}
            <div class="section-label" style="margin-top:1rem;">💰 Pricing Tiers</div>
            @foreach($deal->tiers->sortBy('min_count') as $tier)
                <div style="display:flex; justify-content:space-between; background:#111; border:1px solid {{ $deal->current_participants >= $tier->min_count ? 'var(--primary)' : 'var(--border)' }}; border-radius:7px; padding:0.5rem 0.9rem; margin-bottom:0.4rem; font-size:0.82rem;">
                    <span style="color:#aaa;">{{ $tier->min_count }}+ participants</span>
                    <span style="color:var(--primary); font-family:'Syne',sans-serif; font-weight:700;">${{ number_format($tier->price, 2) }}</span>
                </div>
            @endforeach
        </div>

        {{-- RIGHT: Payment Form --}}
        <div class="card-box">
            <div class="section-label">💳 Payment Details</div>

            {{-- Test card hint --}}
            <div class="test-card-hint">
                🧪 <strong>Test Mode</strong> — Use test card:<br>
                Card: <strong>4242 4242 4242 4242</strong><br>
                Expiry: <strong>any future date</strong> &nbsp; CVC: <strong>any 3 digits</strong>
            </div>

            <div class="error-msg" id="errorMsg"></div>

            <form id="paymentForm">
                @csrf
                <input type="hidden" id="dealId" value="{{ $deal->id }}">
                <input type="hidden" id="paymentIntentId" name="payment_intent_id">

                <label class="form-label-custom">Cardholder Name</label>
                <input type="text" class="input-custom" id="cardName"
                       placeholder="John Doe" required>

                <label class="form-label-custom">Card Number</label>
                <div class="stripe-input-wrapper" id="cardNumberWrapper">
                    <div id="cardNumber"></div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div>
                        <label class="form-label-custom">Expiry Date</label>
                        <div class="stripe-input-wrapper" id="cardExpiryWrapper">
                            <div id="cardExpiry"></div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label-custom">CVC</label>
                        <div class="stripe-input-wrapper" id="cardCvcWrapper">
                            <div id="cardCvc"></div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-pay" id="payBtn">
                    <span id="payBtnText">Pay ${{ number_format($deal->current_price, 2) }} Securely</span>
                    <div class="loading-spinner" id="paySpinner"></div>
                </button>

                <div class="security-note">
                    🔒 Secured by Stripe · Your card details are encrypted
                </div>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const stripe  = Stripe('{{ config('stripe.key') }}');
    const elements = stripe.elements({
        appearance: {
            theme: 'night',
            variables: {
                colorPrimary: '#ff6b2b',
                colorBackground: '#111111',
                colorText: '#ffffff',
                colorDanger: '#dc3545',
                fontFamily: 'DM Sans, sans-serif',
                borderRadius: '8px',
            }
        }
    });

    const cardNumber = elements.create('cardNumber', { style: { base: { color: '#fff', fontSize: '16px' } } });
    const cardExpiry = elements.create('cardExpiry', { style: { base: { color: '#fff', fontSize: '16px' } } });
    const cardCvc    = elements.create('cardCvc',    { style: { base: { color: '#fff', fontSize: '16px' } } });

    cardNumber.mount('#cardNumber');
    cardExpiry.mount('#cardExpiry');
    cardCvc.mount('#cardCvc');

    // Focus effects
    [
        [cardNumber, 'cardNumberWrapper'],
        [cardExpiry, 'cardExpiryWrapper'],
        [cardCvc,    'cardCvcWrapper'],
    ].forEach(([el, wrapperId]) => {
        el.on('focus', () => document.getElementById(wrapperId).classList.add('focused'));
        el.on('blur',  () => document.getElementById(wrapperId).classList.remove('focused'));
        el.on('change', event => {
            const wrapper = document.getElementById(wrapperId);
            wrapper.classList.toggle('error', !!event.error);
        });
    });

    // Form submit
    document.getElementById('paymentForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const payBtn    = document.getElementById('payBtn');
        const spinner   = document.getElementById('paySpinner');
        const btnText   = document.getElementById('payBtnText');
        const errorMsg  = document.getElementById('errorMsg');
        const dealId    = document.getElementById('dealId').value;

        payBtn.disabled = true;
        spinner.style.display = 'block';
        btnText.textContent   = 'Processing...';
        errorMsg.style.display = 'none';

        try {
            // Step 1: Create PaymentIntent on server
            const intentRes = await fetch('{{ route('payment.create.intent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ deal_id: dealId }),
            });

            const intentData = await intentRes.json();

            if (intentData.error) {
                throw new Error(intentData.error);
            }

            // Step 2: Confirm payment with Stripe
            const { error, paymentIntent } = await stripe.confirmCardPayment(
                intentData.client_secret,
                {
                    payment_method: {
                        card: cardNumber,
                        billing_details: {
                            name: document.getElementById('cardName').value,
                        },
                    },
                }
            );

            if (error) {
                throw new Error(error.message);
            }

            // Step 3: Send to server for order creation
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('payment.success') }}';

            const csrfInput = document.createElement('input');
            csrfInput.type  = 'hidden';
            csrfInput.name  = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const piInput = document.createElement('input');
            piInput.type  = 'hidden';
            piInput.name  = 'payment_intent_id';
            piInput.value = paymentIntent.id;

            const dealInput = document.createElement('input');
            dealInput.type  = 'hidden';
            dealInput.name  = 'deal_id';
            dealInput.value = dealId;

            form.appendChild(csrfInput);
            form.appendChild(piInput);
            form.appendChild(dealInput);
            document.body.appendChild(form);
            form.submit();

        } catch (err) {
            errorMsg.textContent   = '❌ ' + err.message;
            errorMsg.style.display = 'block';
            payBtn.disabled        = false;
            spinner.style.display  = 'none';
            btnText.textContent    = 'Pay ${{ number_format($deal->current_price, 2) }} Securely';
        }
    });
</script>
</body>
</html>