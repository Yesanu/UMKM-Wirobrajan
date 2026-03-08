@extends('layout.app')

@section('title', 'Daftar UMKM')
@section('header', 'Daftar UMKM')

@section('content')

<div class="page-header">
    <div>
        <div class="page-header-title">Daftar UMKM</div>
        <div class="page-header-sub">Kelola semua data usaha mikro, kecil, dan menengah</div>
    </div>
    <a href="{{ route('admin.umkm.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah UMKM
    </a>
</div>

{{-- Search & Filter Bar --}}
<form method="GET" action="{{ route('admin.dashboard') }}" class="search-bar">
    <div class="search-input-wrap">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Cari UMKM atau produk…"
               class="form-input search-field" id="search-input">
    </div>

    <select name="tipe" class="form-select" id="filter-tipe">
        <option value="">Semua Tipe</option>
        @foreach ($tipeOptions as $option)
            <option value="{{ $option }}" {{ ($tipe ?? '') === $option ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary btn-sm">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Cari
    </button>

    @if (!empty($search) || !empty($tipe))
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Reset
        </a>
    @endif
</form>

{{-- Active filters info --}}
@if (!empty($search) || !empty($tipe))
    <div class="search-info">
        @if (!empty($search))
            <span>Pencarian: <strong>"{{ $search }}"</strong></span>
        @endif
        @if (!empty($tipe))
            <span>Tipe: <strong>{{ $tipe }}</strong></span>
        @endif
        <span class="search-info-count">{{ $umkms->total() }} hasil</span>
    </div>
@endif

@if ($umkms->isEmpty())
    <div class="empty-state">
        @if (!empty($search) || !empty($tipe))
            <div class="empty-state-icon">🔍</div>
            <div class="empty-state-title">Tidak ditemukan</div>
            <div class="empty-state-text">Tidak ada UMKM yang sesuai dengan pencarian dan filter Anda.</div>
        @else
            <div class="empty-state-icon">🏪</div>
            <div class="empty-state-title">Belum ada data UMKM</div>
            <div class="empty-state-text">Mulai dengan menambahkan UMKM pertama.</div>
        @endif
    </div>
@else
    <div class="umkm-grid">
        @foreach ($umkms as $umkm)
            <div class="card umkm-card">

                {{-- Logo --}}
                <div class="umkm-card-logo">
                    <div class="umkm-logo-wrap">
                        @if ($umkm->logo)
                            <img src="{{ str_starts_with($umkm->logo, 'http') ? $umkm->logo : asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->nama_umkm }}">
                        @else
                            <div class="umkm-logo-placeholder">
                                {{ mb_substr($umkm->nama_umkm, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Body --}}
                <div class="umkm-card-body">
                    @if ($umkm->tipe_umkm)
                        <span class="badge-tipe">{{ $umkm->tipe_umkm }}</span>
                    @endif

                    <span class="badge-status badge-{{ $umkm->status }}"
                          style="font-size:.65rem;margin-bottom:6px;">
                        {{ $umkm->status === 'aktif' ? '✅ Aktif' : ($umkm->status === 'pending' ? '⏳ Pending' : '⛔ Nonaktif') }}
                    </span>

                    <div class="umkm-card-name">{{ $umkm->nama_umkm }}</div>
                    <div class="umkm-card-owner">
                        Pemilik: <span>{{ $umkm->pemilik }}</span>
                    </div>

                    @if ($umkm->deskripsi)
                        <p class="umkm-card-desc">{{ $umkm->deskripsi }}</p>
                    @endif

                    {{-- Product list --}}
                    <div class="umkm-products-list">
                        <div class="umkm-products-list-title">
                            Produk
                            <span style="font-weight:700;color:var(--text-secondary);">
                                ({{ $umkm->products->count() }})
                            </span>
                        </div>
                        <ul>
                            @forelse ($umkm->products->take(3) as $product)
                                <li>
                                    <span>{{ $product->nama_produk }}</span>
                                    <span class="badge-price">Rp{{ number_format($product->harga) }}</span>
                                </li>
                            @empty
                                <li style="color:var(--text-muted);font-style:italic;">Belum ada produk</li>
                            @endforelse
                            @if ($umkm->products->count() > 3)
                                <li style="color:var(--text-muted);font-style:italic;border:none;padding-top:4px;">
                                    +{{ $umkm->products->count() - 3 }} produk lainnya…
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="umkm-card-actions">
                    <a href="{{ route('admin.umkm.products.index', $umkm->id) }}" class="btn btn-primary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
                        </svg>
                        Produk
                    </a>
                    <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="btn btn-secondary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </a>
                    @if ($umkm->status === 'pending')
                        <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST" style="margin:0">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#059669;color:#fff;">✅ Verifikasi</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" style="margin:0">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus UMKM ini?')"
                                class="btn btn-danger btn-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/><path d="M14 11v6"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $umkms->withQueryString()->links() }}
    </div>
@endif

@endsection