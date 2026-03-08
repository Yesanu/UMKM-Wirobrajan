@extends('layout.public')

@section('title', 'UMKM Wirobrajan — Dukung Usaha Lokal')
@section('meta_description', 'Temukan produk dan jasa berkualitas dari UMKM di kelurahan Wirobrajan.')

@section('content')

{{-- Hero --}}
<section class="hero">
    <div class="hero-inner">
        <h1 class="hero-title">Dukung Usaha Lokal<br><span>UMKM Wirobrajan</span></h1>
        <p class="hero-subtitle">Temukan produk dan jasa berkualitas dari pelaku usaha di kelurahan Wirobrajan, Yogyakarta</p>
        <div class="hero-actions">
            <a href="{{ route('stores.index') }}" class="btn btn-primary" style="padding:13px 28px;font-size:.95rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Jelajahi UMKM
            </a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding:13px 28px;font-size:.95rem;">
                    Daftar Sekarang
                </a>
            @endguest
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="pub-section">
    <div class="pub-container">
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\Umkm::where('status','aktif')->count() }}</div>
                <div class="stat-label">UMKM Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\Product::where('status','tersedia')->count() }}</div>
                <div class="stat-label">Produk Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ count(\App\Models\Umkm::TIPE_OPTIONS) }}</div>
                <div class="stat-label">Kategori</div>
            </div>
        </div>
    </div>
</section>

{{-- Featured UMKM --}}
@if ($umkms->isNotEmpty())
<section class="pub-section">
    <div class="pub-container">
        <div class="section-header">
            <h2 class="section-title">UMKM Pilihan</h2>
            <a href="{{ route('stores.index') }}" class="btn btn-ghost btn-sm">
                Lihat Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="umkm-grid">
            @foreach ($umkms as $umkm)
                <a href="{{ route('stores.show', $umkm->id) }}" class="card umkm-pub-card">
                    <div class="umkm-pub-card-logo">
                        @if ($umkm->logo)
                            <img src="{{ str_starts_with($umkm->logo, 'http') ? $umkm->logo : asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->nama_umkm }}">
                        @else
                            <div class="umkm-logo-placeholder" style="width:64px;height:64px;border-radius:50%;font-size:1.5rem;">
                                {{ mb_substr($umkm->nama_umkm, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="umkm-pub-card-body">
                        @if ($umkm->tipe_umkm)
                            <span class="badge-tipe" style="font-size:.6rem;">{{ $umkm->tipe_umkm }}</span>
                        @endif
                        <div class="umkm-pub-card-name">{{ $umkm->nama_umkm }}</div>
                        <div class="umkm-pub-card-sub">{{ $umkm->products->count() }} produk</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Categories --}}
<section class="pub-section" style="background:var(--surface);">
    <div class="pub-container">
        <div class="section-header">
            <h2 class="section-title">Kategori</h2>
        </div>
        <div class="cat-grid">
            @foreach (\App\Models\Umkm::TIPE_OPTIONS as $cat)
                <a href="{{ route('stores.index', ['tipe' => $cat]) }}" class="cat-card">
                    <div class="cat-card-icon">
                        @switch($cat)
                            @case('Makanan & Minuman') 🍽️ @break
                            @case('Kerajinan & Handmade') 🎨 @break
                            @case('Fashion & Pakaian') 👗 @break
                            @case('Jasa') 🔧 @break
                            @case('Pertanian & Peternakan') 🌾 @break
                            @default 📦
                        @endswitch
                    </div>
                    <div class="cat-card-name">{{ $cat }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
