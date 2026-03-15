@extends('layout.public')

@section('title', $umkm->nama_umkm . ' — UMKM Wirobrajan')

@section('content')
<section class="pub-section">
    <div class="pub-container">

        <a href="{{ route('stores.index') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Daftar UMKM
        </a>

        {{-- Store Header --}}
        <div class="store-header">
            <div class="store-header-logo">
                @if ($umkm->logo)
                    <img src="{{ str_starts_with($umkm->logo, 'http') ? $umkm->optimized_logo : asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->nama_umkm }}" loading="lazy">
                @else
                    <div class="umkm-logo-placeholder" style="width:100%;height:100%;font-size:2.5rem;">
                        {{ mb_substr($umkm->nama_umkm, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="store-header-info">
                @if ($umkm->tipe_umkm)
                    <span class="badge-tipe">{{ $umkm->tipe_umkm }}</span>
                @endif
                <h1 class="store-header-name">{{ $umkm->nama_umkm }}</h1>
                <p class="store-header-owner">Pemilik: <strong>{{ $umkm->pemilik }}</strong></p>
                @if ($umkm->deskripsi)
                    <p class="store-header-desc">{{ $umkm->deskripsi }}</p>
                @endif
                <div class="store-header-meta">
                    @if ($umkm->kontak)
                        <span>📞 {{ $umkm->kontak }}</span>
                    @endif
                    @if ($umkm->alamat)
                        <span>📍 {{ $umkm->alamat }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Products --}}
        <div class="section-header" style="margin-top:32px;">
            <h2 class="section-title">Produk ({{ $products->total() }})</h2>
        </div>

        @if ($products->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <div class="empty-state-title">Belum ada produk</div>
                <div class="empty-state-text">UMKM ini belum memiliki produk yang tersedia.</div>
            </div>
        @else
            <div class="product-grid">
                @foreach ($products as $product)
                    <a href="{{ route('stores.product', [$umkm->id, $product->id]) }}" class="card product-pub-card">
                        @if ($product->foto)
                            <img src="{{ str_starts_with($product->foto, 'http') ? $product->thumbnail_foto : asset('storage/'.$product->foto) }}" alt="{{ $product->nama_produk }}" class="product-card-img" loading="lazy">
                        @else
                            <div class="product-card-img-placeholder">🛍️</div>
                        @endif
                        <div class="product-card-body">
                            <div class="product-card-name">{{ $product->nama_produk }}</div>
                            <div class="product-card-price">Rp{{ number_format($product->harga) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
