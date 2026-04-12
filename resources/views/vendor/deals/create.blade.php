<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Deal — TierMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #ff6b2b; --dark: #0f0f0f; --card-bg: #1a1a1a; --border: #2a2a2a; --text-muted: #888; }
        body { background: var(--dark); color: #fff; font-family: 'DM Sans', sans-serif; margin: 0; }
        h1, h2, h3, label { font-family: 'Syne', sans-serif; }
        .page-header { padding: 2.5rem 0 1.5rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
        .form-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 2rem; margin-bottom: 1.5rem; }
        .form-card h5 { font-weight: 700; margin-bottom: 1.5rem; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #ccc; margin-bottom: 0.4rem; display: block; }
        .form-control {
            background: #111; border: 1px solid var(--border); color: #fff;
            border-radius: 8px; padding: 0.65rem 1rem; font-family: 'DM Sans', sans-serif;
            width: 100%; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none; background: #111; border-color: var(--primary);
            color: #fff; box-shadow: 0 0 0 3px rgba(255,107,43,0.15);
        }
        .form-control::placeholder { color: #555; }
        .form-control.is-invalid { border-color: #dc3545; }
        .btn-primary { background: var(--primary); border: none; font-family: 'Syne', sans-serif; font-weight: 700; padding: 0.7rem 2rem; border-radius: 8px; color: #fff; cursor: pointer; }
        .btn-primary:hover { background: #e55a1f; color: #fff; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: #ccc; font-family: 'Syne', sans-serif; font-weight: 600; padding: 0.5rem 1.2rem; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .tier-row { background: #111; border: 1px solid var(--border); border-radius: 10px; padding: 1rem 1.2rem; margin-bottom: 0.8rem; position: relative; }
        .tier-number { font-family: 'Syne', sans-serif; font-weight: 800; color: var(--primary); font-size: 1.1rem; margin-bottom: 0.8rem; }
        .remove-tier { position: absolute; top: 0.8rem; right: 0.8rem; background: transparent; border: 1px solid #3a0000; color: #dc3545; border-radius: 6px; padding: 0.2rem 0.6rem; font-size: 0.78rem; cursor: pointer; transition: all 0.2s; }
        .remove-tier:hover { background: #dc3545; color: #fff; }
        .tier-hint { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.5rem; }
        .preview-box { background: #111; border: 1px solid var(--border); border-radius: 10px; padding: 1.2rem; }
        .preview-tier { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid var(--border); font-size: 0.88rem; }
        .preview-tier:last-child { border-bottom: none; }
        .preview-tier .price { color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 700; }
        .invalid-feedback { color: #dc3545; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
        .error-box { background:#2a0000; border:1px solid #dc3545; color:#dc3545; border-radius:8px; padding:0.8rem 1.2rem; margin-bottom:1.5rem; }

        /* Autocomplete */
        .autocomplete-wrapper { position: relative; }
        .autocomplete-list {
            position: absolute;
            top: 100%; left: 0; right: 0;
            background: #1a1a1a;
            border: 1px solid var(--primary);
            border-top: none;
            border-radius: 0 0 8px 8px;
            z-index: 999;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }
        .autocomplete-item {
            padding: 0.6rem 1rem;
            cursor: pointer;
            font-size: 0.88rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }
        .autocomplete-item:last-child { border-bottom: none; }
        .autocomplete-item:hover { background: rgba(255,107,43,0.1); }
        .autocomplete-item .item-name { color: #fff; }
        .autocomplete-item .item-price { color: var(--primary); font-family: 'Syne', sans-serif; font-weight: 600; font-size: 0.82rem; }

        /* Base price info */
        .price-info {
            background: rgba(255,107,43,0.08);
            border: 1px solid rgba(255,107,43,0.2);
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.82rem;
            color: #aaa;
            margin-top: 0.5rem;
            display: none;
        }
        .price-info span { color: var(--primary); font-weight: 600; }
    </style>
</head>
<body>
@include('vendor.partials.navbar')

<div class="container" style="max-width: 780px;">
    <div class="page-header">
        <h1>Create Group Deal</h1>
        <p style="color: var(--text-muted); margin:0;">Define your deal and configure tiered pricing</p>
    </div>

    @if($errors->any())
        <div class="error-box">
            <strong>Please fix the following errors:</strong>
            <ul style="margin:0.5rem 0 0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.deals.store') }}" id="dealForm">
        @csrf

        <div class="form-card">
            <h5>📋 Deal Information</h5>

            {{-- Product Name with Autocomplete --}}
            <div class="mb-3">
                <label class="form-label">Product Name *</label>
                <div class="autocomplete-wrapper">
                    <input
                        type="text"
                        id="productNameInput"
                        name="product_name"
                        class="form-control @error('product_name') is-invalid @enderror"
                        placeholder="Type to search or enter a new product name..."
                        value="{{ old('product_name') }}"
                        autocomplete="off"
                        required
                    >
                    <div class="autocomplete-list" id="autocompleteList"></div>
                </div>
                @error('product_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="tier-hint">Search existing products or type a new product name</div>
            </div>

            {{-- Base Price --}}
            <div class="mb-3">
                <label class="form-label">Base Price (৳) *</label>
                <input
                    type="number"
                    id="basePriceInput"
                    name="base_price"
                    class="form-control @error('base_price') is-invalid @enderror"
                    placeholder="e.g. 32000"
                    value="{{ old('base_price') }}"
                    min="0"
                    step="0.01"
                    required
                >
                @error('base_price')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="price-info" id="priceInfo">
                    Original base price: <span id="originalPrice"></span> — auto-filled from database. You can change it.
                </div>
                <div class="tier-hint">Set the original price. Tier prices should be lower than this.</div>
            </div>

            {{-- Deal Title --}}
            <div class="mb-3">
                <label class="form-label">Deal Title *</label>
                <input
                    type="text"
                    name="title"
                    id="dealTitle"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="e.g. Samsung Galaxy A54 Group Deal"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="3"
                    placeholder="Describe the deal to buyers...">{{ old('description') }}</textarea>
            </div>

            {{-- Min Participants + Deadline --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Participants *</label>
                    <input
                        type="number"
                        name="min_participants"
                        class="form-control @error('min_participants') is-invalid @enderror"
                        placeholder="e.g. 10"
                        min="2"
                        value="{{ old('min_participants') }}"
                        required
                    >
                    @error('min_participants')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div class="tier-hint">Minimum buyers needed to activate the deal</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Deal Deadline *</label>
                    <input
                        type="datetime-local"
                        name="deadline"
                        class="form-control @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline') }}"
                        required
                    >
                    @error('deadline')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div class="tier-hint">Auto-cancels if minimum not reached by deadline</div>
                </div>
            </div>
        </div>

        {{-- Tiered Pricing --}}
        <div class="form-card">
            <h5>💰 Tiered Pricing Configuration</h5>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">
                Price decreases as more participants join. All tier prices must be below base price.
            </p>

            <div id="tiersContainer">
                <div class="tier-row" id="tier-1">
                    <div class="tier-number">Tier 1</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Minimum Participants</label>
                            <input type="number" name="tiers[0][min_count]"
                                   class="form-control tier-min"
                                   placeholder="e.g. 5" min="1"
                                   value="{{ old('tiers.0.min_count') }}" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Price at this tier (৳)</label>
                            <input type="number" name="tiers[0][price]"
                                   class="form-control tier-price"
                                   placeholder="e.g. 28000" min="0" step="0.01"
                                   value="{{ old('tiers.0.price') }}" required>
                        </div>
                    </div>
                    <div class="tier-hint">When <strong>5+</strong> people join → price becomes this amount</div>
                </div>
            </div>

            <button type="button" class="btn-outline mt-2" onclick="addTier()">+ Add Another Tier</button>

            {{-- Live Preview --}}
            <div style="margin-top: 1.5rem;">
                <div style="font-size:0.82rem; color: var(--text-muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.6rem; font-family:'Syne',sans-serif;">
                    Live Pricing Preview
                </div>
                <div class="preview-box" id="previewBox">
                    <div style="color: var(--text-muted); font-size:0.85rem; text-align:center; padding:0.5rem;">
                        Fill in tier details to see preview
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-end pb-5">
            <a href="{{ route('vendor.deals.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Create Deal →</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // All products from DB for autocomplete
    const allProducts = @json($products);

    const productInput  = document.getElementById('productNameInput');
    const basePriceInput = document.getElementById('basePriceInput');
    const autocompleteList = document.getElementById('autocompleteList');
    const priceInfo     = document.getElementById('priceInfo');
    const originalPrice = document.getElementById('originalPrice');
    const dealTitle     = document.getElementById('dealTitle');

    // Autocomplete logic
    productInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        autocompleteList.innerHTML = '';

        if (query.length < 1) {
            autocompleteList.style.display = 'none';
            return;
        }

        const matches = allProducts.filter(p =>
            p.name.toLowerCase().includes(query)
        );

        if (matches.length === 0) {
            autocompleteList.style.display = 'none';
            // Clear price info if no match
            priceInfo.style.display = 'none';
            return;
        }

        matches.forEach(product => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.innerHTML = `
                <span class="item-name">${product.name}</span>
                <span class="item-price">৳${parseFloat(product.base_price).toLocaleString()}</span>
            `;
            item.addEventListener('click', function () {
                // Fill in product name
                productInput.value = product.name;

                // Auto-fill base price
                basePriceInput.value = product.base_price;

                // Show price info
                originalPrice.textContent = '৳' + parseFloat(product.base_price).toLocaleString();
                priceInfo.style.display = 'block';

                // Auto-suggest deal title
                if (!dealTitle.value) {
                    dealTitle.value = product.name + ' Group Deal';
                }

                autocompleteList.style.display = 'none';
                updatePreview();
            });
            autocompleteList.appendChild(item);
        });

        autocompleteList.style.display = 'block';
    });

    // Hide autocomplete when clicking outside
    document.addEventListener('click', function (e) {
        if (!productInput.contains(e.target) && !autocompleteList.contains(e.target)) {
            autocompleteList.style.display = 'none';
        }
    });

    // Tier management
    let tierCount = 1;

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
                    <input type="number" name="tiers[${tierCount - 1}][min_count]"
                           class="form-control tier-min" placeholder="e.g. 10" min="1" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Price at this tier (৳)</label>
                    <input type="number" name="tiers[${tierCount - 1}][price]"
                           class="form-control tier-price" placeholder="e.g. 26000" min="0" step="0.01" required>
                </div>
            </div>
            <div class="tier-hint">When more people join → price drops to this amount</div>`;
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
        const rows  = document.querySelectorAll('.tier-row');
        const tiers = [];
        rows.forEach(row => {
            const min   = row.querySelector('.tier-min')?.value;
            const price = row.querySelector('.tier-price')?.value;
            if (min && price) tiers.push({ min: parseInt(min), price: parseFloat(price) });
        });
        tiers.sort((a, b) => a.min - b.min);
        const box = document.getElementById('previewBox');
        if (tiers.length === 0) {
            box.innerHTML = '<div style="color:#888;font-size:0.85rem;text-align:center;padding:0.5rem;">Fill in tier details to see preview</div>';
            return;
        }
        const base = parseFloat(basePriceInput.value) || null;
        box.innerHTML = (base ? `<div class="preview-tier"><span>🔵 Base price</span><span class="price">৳${base.toLocaleString()}</span></div>` : '')
            + tiers.map((t, i) => `
            <div class="preview-tier">
                <span>${i === 0 ? '🟡' : '🟢'} ${t.min}+ participants</span>
                <span class="price">৳${t.price.toLocaleString()}</span>
            </div>`).join('');
    }

    attachListeners();
    basePriceInput.addEventListener('input', updatePreview);
    document.querySelectorAll('.tier-min, .tier-price').forEach(i => i.addEventListener('input', updatePreview));
</script>
</body>
</html>