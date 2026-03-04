<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Wirobrajan') — Panel Admin</title>
    <meta name="description" content="Panel administrasi UMKM Wirobrajan">
    @vite('resources/css/app.css')
</head>
<body>

<div class="app-shell">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar" id="sidebar">

        <a href="{{ route('umkm.index') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">U</div>
            <div>
                <div class="sidebar-brand-text">UMKM Wirobrajan</div>
                <div class="sidebar-brand-sub">Panel Administrasi</div>
            </div>
        </a>

        <hr class="sidebar-divider">

        <div class="sidebar-section-label">Menu Utama</div>

        <nav class="sidebar-nav">
            <a href="{{ route('umkm.index') }}"
               class="sidebar-link {{ request()->routeIs('umkm.*') && !request()->routeIs('umkm.products.*') ? 'active' : '' }}">
                {{-- Store icon --}}
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9L12 2l9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Daftar UMKM
            </a>
        </nav>

        <div class="sidebar-footer">
            &copy; {{ date('Y') }} UMKM Wirobrajan<br>
            Gereja Kristen Jawa
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    {{-- ── Main Wrapper ── --}}
    <div class="main-wrapper">

        {{-- Top Bar --}}
        <header class="topbar">
            {{-- Hamburger (mobile) --}}
            <button onclick="openSidebar()" id="hamburger"
                    style="display:none; background:none; border:none; cursor:pointer; padding:4px; color:var(--text-secondary);"
                    aria-label="Buka menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            <div class="topbar-title">@yield('header', 'Dashboard')</div>
            <div class="topbar-badge">Admin</div>
        </header>

        {{-- Page Content --}}
        <main class="page-content">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="flash flash-success" id="flash-msg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flash flash-error" id="flash-msg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

    </div>{{-- /main-wrapper --}}

</div>{{-- /app-shell --}}

<script>
    // Auto-dismiss flash after 5s
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity .4s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 420);
        }, 5000);
    }

    // Mobile sidebar
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const hamburger = document.getElementById('hamburger');

    function checkMobile() {
        if (window.innerWidth <= 768) {
            hamburger.style.display = 'block';
        } else {
            hamburger.style.display = 'none';
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }
    }
    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    }
    checkMobile();
    window.addEventListener('resize', checkMobile);
</script>

</body>
</html>