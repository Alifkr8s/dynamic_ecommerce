<nav style="
    background: #111;
    border-bottom: 1px solid #2a2a2a;
    padding: 0.9rem 0;
    position: sticky;
    top: 0;
    z-index: 100;
">
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem; display:flex; align-items:center; justify-content:space-between;">

        {{-- Brand --}}
        <a href="{{ url('/') }}" style="
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: #ff6b2b;
            text-decoration: none;
            letter-spacing: -0.02em;
        ">TierMart</a>

        {{-- Nav Links --}}
        <div style="display:flex; align-items:center; gap:0.5rem;">
            <a href="{{ route('vendor.deals.index') }}" style="
                color: {{ request()->routeIs('vendor.deals.index') ? '#ff6b2b' : '#aaa' }};
                text-decoration: none;
                font-family: 'Syne', sans-serif;
                font-size: 0.88rem;
                font-weight: 600;
                padding: 0.45rem 0.9rem;
                border-radius: 7px;
                background: {{ request()->routeIs('vendor.deals.index') ? 'rgba(255,107,43,0.1)' : 'transparent' }};
                transition: all 0.2s;
            ">My Deals</a>

            <a href="{{ route('vendor.deals.create') }}" style="
                color: {{ request()->routeIs('vendor.deals.create') ? '#ff6b2b' : '#aaa' }};
                text-decoration: none;
                font-family: 'Syne', sans-serif;
                font-size: 0.88rem;
                font-weight: 600;
                padding: 0.45rem 0.9rem;
                border-radius: 7px;
                background: {{ request()->routeIs('vendor.deals.create') ? 'rgba(255,107,43,0.1)' : 'transparent' }};
                transition: all 0.2s;
            ">+ New Deal</a>
        </div>

        {{-- User Info + Logout --}}
        <div style="display:flex; align-items:center; gap:1rem;">
            <span style="
                color: #888;
                font-size: 0.85rem;
                font-family: 'DM Sans', sans-serif;
            ">👤 {{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" style="
                    background: transparent;
                    border: 1px solid #2a2a2a;
                    color: #aaa;
                    border-radius: 7px;
                    padding: 0.35rem 0.9rem;
                    font-size: 0.82rem;
                    font-family: 'Syne', sans-serif;
                    cursor: pointer;
                    transition: all 0.2s;
                " onmouseover="this.style.borderColor='#ff6b2b';this.style.color='#ff6b2b'"
                   onmouseout="this.style.borderColor='#2a2a2a';this.style.color='#aaa'">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>