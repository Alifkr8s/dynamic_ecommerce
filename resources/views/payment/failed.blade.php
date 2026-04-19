<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }
        h1,h2,h3 { font-family: 'Syne', sans-serif; }

        .failed-card { background: var(--card-bg); border: 1px solid #3a0000; border-radius: 20px; padding: 3rem 2.5rem; max-width: 480px; width: 100%; text-align: center; position: relative; overflow: hidden; }
        .failed-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #dc3545, #ff6b6b); }

        .failed-icon { width: 80px; height: 80px; background: rgba(220,53,69,0.1); border: 2px solid rgba(220,53,69,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.2rem; }
        .failed-title { font-size: 1.8rem; font-weight: 800; color: #dc3545; margin-bottom: 0.5rem; }
        .failed-sub { color: var(--text-muted); font-size: 0.92rem; margin-bottom: 2rem; line-height: 1.6; }

        .btn-retry { display: inline-block; background: var(--primary); color: #fff; font-family: 'Syne', sans-serif; font-weight: 700; padding: 0.75rem 2rem; border-radius: 10px; text-decoration: none; margin: 0.4rem; transition: background 0.2s; }
        .btn-retry:hover { background: #e55a1f; color: #fff; }
        .btn-home { display: inline-block; background: transparent; color: #ccc; font-family: 'Syne', sans-serif; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; border: 1px solid var(--border); margin: 0.4rem; transition: all 0.2s; }
        .btn-home:hover { border-color: var(--primary); color: var(--primary); }
    </style>
</head>
<body>
<div class="failed-card">
    <div class="failed-icon">❌</div>
    <h2 class="failed-title">Payment Failed</h2>
    <p class="failed-sub">
        Your payment could not be processed. No charges were made to your card.
        Please check your card details and try again.
    </p>
    <div>
        <a href="{{ url()->previous() }}" class="btn-retry">Try Again</a>
        <a href="{{ url('/') }}" class="btn-home">← Home</a>
    </div>
</div>
</body>
</html>