@extends('layout.public')

@section('title', $product->nama_produk . ' — ' . $umkm->nama_umkm)

@section('content')
<section class="pub-section">
    <div class="pub-container">

        <a href="{{ route('stores.show', $umkm->id) }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke {{ $umkm->nama_umkm }}
        </a>

        <div class="product-detail">
            {{-- Image --}}
            <div class="product-detail-img-wrap">
                @if ($product->foto)
                    <img src="{{ str_starts_with($product->foto, 'http') ? $product->optimized_foto : asset('storage/'.$product->foto) }}" alt="{{ $product->nama_produk }}" class="product-detail-img" loading="lazy">
                @else
                    <div class="product-card-img-placeholder" style="height:360px;border-radius:var(--radius-lg);">🛍️</div>
                @endif
            </div>

            {{-- Info --}}
            <div class="product-detail-info">
                @if ($umkm->tipe_umkm)
                    <span class="badge-tipe">{{ $umkm->tipe_umkm }}</span>
                @endif
                <h1 class="product-detail-name">{{ $product->nama_produk }}</h1>
                <div class="product-detail-price">Rp{{ number_format($product->harga) }}</div>

                @if ($product->deskripsi)
                    <div class="product-detail-desc">
                        <h3>Deskripsi</h3>
                        <p>{{ $product->deskripsi }}</p>
                    </div>
                @endif

                {{-- WhatsApp Order Button --}}
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-wa" id="wa-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Pesan via WhatsApp
                </a>

                {{-- Store info --}}
                <div class="product-detail-store">
                    <div class="product-detail-store-logo">
                        @if ($umkm->logo)
                            <img src="{{ str_starts_with($umkm->logo, 'http') ? $umkm->optimized_logo : asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->nama_umkm }}" loading="lazy">
                        @else
                            <div class="umkm-logo-placeholder" style="width:100%;height:100%;font-size:1.2rem;">{{ mb_substr($umkm->nama_umkm, 0, 1) }}</div>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('stores.show', $umkm->id) }}" style="font-weight:700;color:var(--text-primary);text-decoration:none;">{{ $umkm->nama_umkm }}</a>
                        <div style="font-size:.8rem;color:var(--text-muted);">{{ $umkm->pemilik }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
