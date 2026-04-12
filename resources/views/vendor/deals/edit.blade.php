<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Deal — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; margin: 0; }
        h1, h2, h3, label { font-family: 'Syne', sans-serif; }
        .page-header { padding: 2.5rem 0 1.5rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
        .form-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 2rem; margin-bottom: 1.5rem; }
        .form-card h5 { font-weight: 700; margin-bottom: 1.5rem; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #ccc; margin-bottom: 0.4rem; }
        .form-control, .form-select { background: #111; border: 1px solid var(--border); color: #fff; border-radius: 8px; padding: 0.65rem 1rem; font-family: 'DM Sans', sans-serif; }
        .form-control:focus, .form-select:focus { background: #111; border-color: var(--primary); color: #fff; box-shadow: 0 0 0 3px rgba(255,107,43,0.15); }
        .form-select option { background: #1a1a1a; color: #fff; }
        .btn-primary { background: var(--primary); border: none; font-family: 'Syne', sans-serif; font-weight: 700; padding: 0.7rem 2rem; border-radius: 8px; color: #fff; cursor: pointer; }
        .btn-primary:hover { background: #e55a1f; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: #ccc; font-family: 'Syne', sans-serif; font-weight: 600; padding: 0.5rem 1.2rem; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .tier-row { background: #111; border: 1px solid var(--border); border-radius: 10px; padding: 1rem 1.2rem; margin-bottom: 0.8rem; position: relative; }
        .tier-number { font-family: 'Syne', sans-serif; font-weight: 800; color: var(--primary); font-size: 1.1rem; margin-bottom: 0.8rem; }
        .remove-tier { position: absolute; top: 0.8rem; right: 0.8rem; background: transparent; border: 1px solid #3a0000; color: #dc3545; border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.78rem; cursor: pointer; }
        .remove-tier:hover { background: #dc3545; color: #fff; }
        .tier-hint { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.5rem; }
        .preview-box { background: #111; border: 1px solid var(--border); border-radius: 10px; padding: 1.2rem; }
        .preview-tier { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border); font-size: 0.88rem; }
        .preview-tier:last-child { border-bottom: none; }
        .preview-tier .price { color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 700; }
        .invalid-feedback { color: #dc3545; font-size: 0.8rem; }
        .is-invalid { border-color: #dc3545 !important; }
    </style>
</head>
<body>
@include('vendor.partials.navbar')

<div class="container" style="max-width: 780px;">
    <div class="page-header">
        <h1>Edit Deal</h1>
        <p style="color: var(--text-muted); margin:0;">Update deal details and pricing tiers</p>
    </div>

    @if($errors->any())
        <div style="background:#2a0000; border:1px solid #dc3545; color:#dc3545; border-radius:8px; padding:0.8rem 1.2rem; margin-bottom:1.5rem;">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.deals.update', $deal->id) }}">
        @csrf @method('PUT')

        <div class="form-card">
            <h5>📋 Deal Information</h5>
            <div class="mb-3">
                <label class="form-label">Product</label>
                <select class="form-select" disabled>
                    @foreach($products as $product)
                        <option {{ $deal->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="product_id" value="{{ $deal->product_id }}">
                <div class="tier-hint">Product cannot be changed after creation</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deal Title *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $deal->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $deal->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Participants *</label>
                    <input type="number" name="min_participants" class="form-control"
                           value="{{ old('min_participants', $deal->min_participants) }}" min="2" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Deal Deadline *</label>
                    <input type="datetime-local" name="deadline" class="form-control"
                           value="{{ old('deadline', \Carbon\Carbon::parse($deal->deadline)->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h5>💰 Pricing Tiers</h5>
            <div id="tiersContainer">
                @foreach($deal->tiers->sortBy('min_count') as $i => $tier)
                <div class="tier-row" id="tier-{{ $i + 1 }}">
                    <div class="tier-number">Tier {{ $i + 1 }}</div>
                    @if($i > 0)
                        <button type="button" class="remove-tier" onclick="removeTier({{ $i + 1 }})">✕ Remove</button>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Minimum Participants</label>
                            <input type="number" name="tiers[{{ $i }}][min_count]"
                                   class="form-control tier-min" value="{{ $tier->min_count }}" min="1" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Price (৳)</label>
                            <input type="number" name="tiers[{{ $i }}][price]"
                                   class="form-control tier-price" value="{{ $tier->price }}" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-outline mt-2" onclick="addTier()">+ Add Tier</button>
            <div style="margin-top: 1.5rem;">
                <div style="font-size:0.82rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.6rem; font-family:'Syne',sans-serif;">Live Preview</div>
                <div class="preview-box" id="previewBox"></div>
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-end pb-5">
            <a href="{{ route('vendor.deals.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Update Deal →</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let tierCount = {{ $deal->tiers->count() }};

    function addTier() {
        tierCount++;
        const container = document.getElementById('tiersContainer');
        const div = document.createElement('div');
        div.className = 'tier-row';
        div.id = 'tier-' + tierCount;
        div.innerHTML = `
            <div class="tier-number">Tier ${tierCount}</div>
            <button type="button" class="remove-tier" onclick="removeTier(${tierCount})">✕ Remove</button>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Minimum Participants</label>
                    <input type="number" name="tiers[${tierCount-1}][min_count]" class="form-control tier-min" min="1" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Price (৳)</label>
                    <input type="number" name="tiers[${tierCount-1}][price]" class="form-control tier-price" min="0" step="0.01" required>
                </div>
            </div>`;
        container.appendChild(div);
        attachListeners();
        updatePreview();
    }

    function removeTier(id) {
        document.getElementById('tier-' + id)?.remove();
        updatePreview();
    }

    function attachListeners() {
        document.querySelectorAll('.tier-min, .tier-price').forEach(input => {
            input.removeEventListener('input', updatePreview);
            input.addEventListener('input', updatePreview);
        });
    }

    function updatePreview() {
        const tiers = [];
        document.querySelectorAll('.tier-row').forEach(row => {
            const min = row.querySelector('.tier-min')?.value;
            const price = row.querySelector('.tier-price')?.value;
            if (min && price) tiers.push({ min: parseInt(min), price: parseFloat(price) });
        });
        tiers.sort((a, b) => a.min - b.min);
        const box = document.getElementById('previewBox');
        box.innerHTML = tiers.length === 0
            ? '<div style="color:#888;font-size:0.85rem;text-align:center;padding:0.5rem;">No tiers yet</div>'
            : tiers.map((t, i) => `<div class="preview-tier"><span>${i===0?'🟡':'🟢'} ${t.min}+ participants</span><span class="price">৳${t.price.toLocaleString()}</span></div>`).join('');
    }

    attachListeners();
    updatePreview();
</script>
</body>
</html>