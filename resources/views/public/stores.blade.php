@extends('layout.public')

@section('title', 'Jelajahi UMKM — UMKM Wirobrajan')

@section('content')
<section class="pub-section">
    <div class="pub-container">

        <div class="section-header" style="margin-bottom:8px;">
            <h1 class="section-title" style="font-size:1.5rem;">Jelajahi UMKM</h1>
        </div>
        <p style="color:var(--text-muted);margin-bottom:24px;font-size:.9rem;">Temukan produk dan jasa dari UMKM di Wirobrajan</p>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('stores.index') }}" class="search-bar">
            <div class="search-input-wrap">
                <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Cari UMKM atau produk…"
                       class="form-input search-field">
            </div>
            <select name="tipe" class="form-select">
                <option value="">Semua Tipe</option>
                @foreach ($tipeOptions as $option)
                    <option value="{{ $option }}" {{ ($tipe ?? '') === $option ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
            @if (!empty($search) || !empty($tipe))
                <a href="{{ route('stores.index') }}" class="btn btn-ghost btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reset
                </a>
            @endif
        </form>

        @if (!empty($search) || !empty($tipe))
            <div class="search-info" style="margin-top:-8px;">
                @if (!empty($search)) <span>Pencarian: <strong>"{{ $search }}"</strong></span> @endif
                @if (!empty($tipe)) <span>Tipe: <strong>{{ $tipe }}</strong></span> @endif
                <span class="search-info-count">{{ $umkms->total() }} hasil</span>
            </div>
        @endif

        @if ($umkms->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <div class="empty-state-title">Tidak ditemukan</div>
                <div class="empty-state-text">Tidak ada UMKM yang sesuai dengan pencarian Anda.</div>
            </div>
        @else
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
                            <div class="umkm-pub-card-sub">{{ $umkm->products->count() }} produk • {{ $umkm->pemilik }}</div>
                            @if ($umkm->deskripsi)
                                <p class="umkm-pub-card-desc">{{ Str::limit($umkm->deskripsi, 80) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $umkms->withQueryString()->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
