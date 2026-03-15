<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Wirobrajan')</title>
    <meta name="description" content="@yield('meta_description', 'E-commerce UMKM Wirobrajan — Gereja Kristen Jawa')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>

{{-- ── Public Navbar ── --}}
<header class="pub-navbar" id="pub-navbar">
    <div class="pub-navbar-inner">
        <a href="{{ route('home') }}" class="pub-navbar-brand">
            <div class="pub-navbar-brand-icon">U</div>
            <div>
                <div class="pub-navbar-brand-text">UMKM Wirobrajan</div>
                <div class="pub-navbar-brand-sub">Gereja Kristen Jawa</div>
            </div>
        </a>

        <nav class="pub-navbar-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('stores.index') }}" class="{{ request()->routeIs('stores.*') ? 'active' : '' }}">Jelajahi UMKM</a>
        </nav>

        <div class="pub-navbar-actions">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Panel Admin</a>
                @elseif (auth()->user()->isPemilik())
                    <a href="{{ route('owner.dashboard') }}" class="btn btn-ghost btn-sm">Dashboard Saya</a>
                @endif
                <div class="pub-user-menu">
                    <button class="pub-user-btn" onclick="toggleUserMenu()">
                        <span class="pub-user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                        <span class="pub-user-name">{{ auth()->user()->name }}</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="pub-user-dropdown" id="user-dropdown">
                        <div class="pub-user-dropdown-header">
                            <div class="pub-user-dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="pub-user-dropdown-role">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="pub-user-dropdown-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button class="pub-hamburger" onclick="toggleMobileMenu()" id="pub-hamburger">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div class="pub-mobile-menu" id="pub-mobile-menu">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('stores.index') }}">Jelajahi UMKM</a>
        <hr>
        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
            @elseif (auth()->user()->isPemilik())
                <a href="{{ route('owner.dashboard') }}">Dashboard Saya</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer;display:block;width:100%;padding:10px 0;color:var(--danger);">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endauth
    </div>
</header>

{{-- ── Flash Messages ── --}}
<div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    @if (session('success'))
        <div class="flash flash-success" id="flash-msg" style="margin-top:20px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="flash flash-error" id="flash-msg" style="margin-top:20px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

{{-- ── Page Content ── --}}
<main>
    @yield('content')
</main>

{{-- ── Footer ── --}}
<footer class="pub-footer">
    <div class="pub-footer-inner">
        <div class="pub-footer-brand">
            <div class="pub-navbar-brand-icon" style="width:32px;height:32px;font-size:14px;">U</div>
            <div>
                <strong>UMKM Wirobrajan</strong><br>
                <span>Gereja Kristen Jawa</span>
            </div>
        </div>
        <div class="pub-footer-copy">
            &copy; {{ date('Y') }} UMKM Wirobrajan. Hak cipta dilindungi.
        </div>
    </div>
</footer>

<script>
    // Auto-dismiss flash
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity .4s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 420);
        }, 5000);
    }

    // User dropdown
    function toggleUserMenu() {
        const dd = document.getElementById('user-dropdown');
        dd.classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('user-dropdown');
        if (dd && !e.target.closest('.pub-user-menu')) {
            dd.classList.remove('open');
        }
    });

    // Mobile menu
    function toggleMobileMenu() {
        document.getElementById('pub-mobile-menu').classList.toggle('open');
    }
</script>

</body>
</html>
