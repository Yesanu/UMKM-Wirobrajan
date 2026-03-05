@extends('layout.app')

@section('title', 'Produk — ' . $umkm->nama_umkm)
@section('header', 'Produk UMKM')

@section('content')

<a href="{{ route('admin.dashboard') }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Daftar UMKM
</a>

<div class="page-header">
    <div>
        <div class="page-header-title">Produk: {{ $umkm->nama_umkm }}</div>
        <div class="page-header-sub">
            {{ $products->total() }} produk terdaftar
        </div>
    </div>
    <a href="{{ route('admin.umkm.products.create', $umkm->id) }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Produk
    </a>
</div>

@if ($products->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <div class="empty-state-title">Belum ada produk</div>
        <div class="empty-state-text">Tambahkan produk pertama untuk UMKM ini.</div>
    </div>
@else
    <div class="product-grid">
        @foreach ($products as $product)
            <div class="card product-card">

                {{-- Image --}}
                @if ($product->foto)
                    <img src="{{ asset('storage/'.$product->foto) }}"
                         alt="{{ $product->nama_produk }}"
                         class="product-card-img">
                @else
                    <div class="product-card-img-placeholder">🛍️</div>
                @endif

                {{-- Body --}}
                <div class="product-card-body">
                    <div class="product-card-name">{{ $product->nama_produk }}</div>
                    <div class="product-card-price">Rp{{ number_format($product->harga) }}</div>
                    @if ($product->deskripsi)
                        <p class="product-card-desc">{{ $product->deskripsi }}</p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="product-card-actions">
                    <a href="{{ route('admin.umkm.products.edit', [$umkm->id, $product->id]) }}"
                       class="btn btn-secondary btn-sm">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.umkm.products.destroy', [$umkm->id, $product->id]) }}"
                          method="POST" style="margin:0">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                class="btn btn-danger btn-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $products->links() }}
    </div>
@endif

@endsection