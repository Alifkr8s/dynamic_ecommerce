<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TierMart — Group Buying Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        h1, h2, h3, h4, h5, nav { font-family: 'Syne', sans-serif; }

        /* Navbar */
        .navbar {
            background: rgba(17,17,17,0.95);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary) !important;
            text-decoration: none;
            letter-spacing: -0.02em;
        }
        .nav-login-btn {
            background: var(--primary);
            color: #fff !important;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            padding: 0.5rem 1.4rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .nav-login-btn:hover { background: #e55a1f; color: #fff !important; }
        .nav-link-plain {
            color: #aaa !important;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            padding: 0.5rem 0.9rem;
            border-radius: 7px;
            transition: color 0.2s;
        }
        .nav-link-plain:hover { color: #fff !important; }

        /* Hero */
        .hero {
            min-height: 88vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255,107,43,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,107,43,0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,107,43,0.12);
            border: 1px solid rgba(255,107,43,0.3);
            color: var(--primary);
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            margin-bottom: 1.8rem;
        }
        .hero h1 {
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
        }
        .hero h1 .highlight {
            color: var(--primary);
            position: relative;
        }
        .hero p {
            font-size: 1.15rem;
            color: #aaa;
            line-height: 1.7;
            max-width: 540px;
            margin-bottom: 2.5rem;
            font-weight: 300;
        }
        .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
        .btn-hero-primary {
            background: var(--primary);
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            padding: 0.85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-hero-primary:hover { background: #e55a1f; color: #fff; transform: translateY(-1px); }
        .btn-hero-outline {
            background: transparent;
            color: #ccc;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            padding: 0.85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1rem;
            border: 1px solid var(--border);
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-hero-outline:hover { border-color: #555; color: #fff; }

        /* Stats */
        .stats-row {
            display: flex;
            gap: 2.5rem;
            margin-top: 3.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }
        .stat-item .num {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            color: #fff;
        }
        .stat-item .num span { color: var(--primary); }
        .stat-item .label { font-size: 0.82rem; color: var(--text-muted); margin-top: 0.2rem; }

        /* Hero visual */
        .hero-visual {
            position: relative;
            padding: 1rem;
        }
        .deal-card-demo {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        .deal-card-demo::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #ff9a5c);
        }
        .deal-card-demo .product-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }
        .deal-card-demo .product-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }
        .tier-demo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #111;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.9rem;
            margin-bottom: 0.5rem;
            font-size: 0.82rem;
        }
        .tier-demo .tier-price { color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 700; }
        .tier-demo.active-tier { border-color: var(--primary); background: rgba(255,107,43,0.05); }
        .progress-demo { height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; margin: 1rem 0 0.4rem; }
        .progress-demo-fill { height: 100%; background: linear-gradient(90deg, var(--primary), #ff9a5c); border-radius: 3px; width: 70%; }
        .progress-label { display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted); }
        .countdown-badge {
            display: inline-block;
            background: rgba(255,107,43,0.1);
            border: 1px solid rgba(255,107,43,0.2);
            color: var(--primary);
            font-size: 0.75rem;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 6px;
            margin-bottom: 0.8rem;
        }

        /* Features */
        .features { padding: 5rem 0; border-top: 1px solid var(--border); }
        .section-label {
            font-size: 0.78rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.8rem;
            height: 100%;
            transition: border-color 0.2s, transform 0.2s;
        }
        .feature-card:hover { border-color: var(--primary); transform: translateY(-3px); }
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }
        .feature-card h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.6rem;
        }
        .feature-card p { font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin: 0; }

        /* CTA */
        .cta-section {
            padding: 5rem 0;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .cta-box {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .cta-box::before {
            content: '';
            position: absolute;
            top: -100px; left: 50%;
            transform: translateX(-50%);
            width: 400px; height: 300px;
            background: radial-gradient(circle, rgba(255,107,43,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-box h2 {
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        .cta-box p { color: #aaa; margin-bottom: 2rem; font-size: 1rem; }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.82rem;
        }
        footer span { color: var(--primary); }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="navbar-brand">TierMart</a>
        <div class="d-flex align-items-center gap-3">
            @auth
                <a href="{{ route('vendor.deals.index') }}" class="nav-link-plain">My Deals</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:transparent; border:1px solid var(--border); color:#aaa; border-radius:7px; padding:0.45rem 1rem; font-size:0.85rem; font-family:'Syne',sans-serif; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link-plain">Login</a>
                <a href="{{ route('login') }}" class="nav-login-btn">Get Started →</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">🔥 Group Buying Platform</div>
                <h1>
                    Welcome to<br>
                    <span class="highlight">TierMart</span>
                </h1>
                <p>
                    The smarter way to buy together. Join group deals, unlock tiered pricing,
                    and save more as more people participate. Vendors set the tiers — buyers reap the rewards.
                </p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn-hero-primary">Login to Your Account →</a>
                    <a href="#how-it-works" class="btn-hero-outline">How it works</a>
                </div>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="num">20<span>+</span></div>
                        <div class="label">Active Deals</div>
                    </div>
                    <div class="stat-item">
                        <div class="num">4<span>+</span></div>
                        <div class="label">Trusted Vendors</div>
                    </div>
                    <div class="stat-item">
                        <div class="num">15<span>+</span></div>
                        <div class="label">Happy Buyers</div>
                    </div>
                </div>
            </div>

            {{-- Demo Card --}}
            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="deal-card-demo">
                        <div class="countdown-badge">⏰ Ends in 2 days 14 hrs</div>
                        <div class="product-name">Samsung Galaxy A54 Group Deal</div>
                        <div class="product-sub">📦 Rahim Electronics · 14 joined so far</div>
                        <div class="tier-demo">
                            <span>5+ participants</span>
                            <span class="tier-price">৳30,000</span>
                        </div>
                        <div class="tier-demo active-tier">
                            <span>✅ 10+ participants (current)</span>
                            <span class="tier-price">৳28,000</span>
                        </div>
                        <div class="tier-demo">
                            <span>15+ participants</span>
                            <span class="tier-price">৳26,000</span>
                        </div>
                        <div class="progress-demo">
                            <div class="progress-demo-fill"></div>
                        </div>
                        <div class="progress-label">
                            <span>14 joined</span>
                            <span>Need 15 for next tier</span>
                        </div>
                    </div>

                    <div class="deal-card-demo" style="opacity:0.6; transform: scale(0.97); margin-bottom:0;">
                        <div class="countdown-badge">⏰ Ends in 5 days</div>
                        <div class="product-name">Wireless Earbuds Flash Deal</div>
                        <div class="product-sub">📦 Sumon Gadgets · 3 joined so far</div>
                        <div class="tier-demo">
                            <span>4+ participants</span>
                            <span class="tier-price">৳2,300</span>
                        </div>
                        <div class="tier-demo">
                            <span>8+ participants</span>
                            <span class="tier-price">৳2,200</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="features" id="how-it-works">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">How it works</div>
            <h2 class="section-title">Simple. Smart. Savings.</h2>
            <p style="color:#aaa; max-width:500px; margin:0 auto; font-size:0.95rem;">
                TierMart connects vendors and buyers through time-limited group deals with dynamic pricing.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">🏷️</span>
                    <h4>Vendors Create Deals</h4>
                    <p>Vendors list products with tiered pricing — the more people join, the lower the price drops for everyone.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">👥</span>
                    <h4>Buyers Join Together</h4>
                    <p>Buyers browse active deals and join group purchases. As participant count grows, price tiers unlock automatically.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">⚡</span>
                    <h4>Deal Activates Automatically</h4>
                    <p>Once the minimum participant count is reached before the deadline, the deal activates and orders are confirmed.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">💰</span>
                    <h4>Tiered Pricing Engine</h4>
                    <p>Prices drop in real time as more buyers join. Each tier has a minimum count and a corresponding lower price.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">🔒</span>
                    <h4>Secure Payments</h4>
                    <p>Payments are processed securely via Stripe. If a deal fails, automatic refunds are issued immediately.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <span class="feature-icon">📦</span>
                    <h4>Order Tracking</h4>
                    <p>Track your orders from confirmation to delivery. Get notified at every step of the process.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-box">
            <h2>Ready to Start?</h2>
            <p>Login as a vendor to create deals or as a buyer to join group purchases.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('login') }}" class="btn-hero-primary">Login Now →</a>
            </div>
            <div style="margin-top:2rem; display:flex; gap:2rem; justify-content:center; flex-wrap:wrap;">
                <div style="font-size:0.82rem; color:var(--text-muted);">
                    🔑 Vendor login: <span style="color:#ccc;">rahim@example.com</span>
                </div>
                <div style="font-size:0.82rem; color:var(--text-muted);">
                    🛒 Buyer login: <span style="color:#ccc;">tanvir@example.com</span>
                </div>
                <div style="font-size:0.82rem; color:var(--text-muted);">
                    🔑 Password: <span style="color:#ccc;">password</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer>
    <div class="container">
        <p>© 2026 <span>TierMart</span> — Dynamic Group Buying Platform. Built with Laravel MVC.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>