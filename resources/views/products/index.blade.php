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
                    <img src="{{ str_starts_with($product->foto, 'http') ? $product->foto : asset('storage/'.$product->foto) }}"
                         alt="{{ $product->nama_produk }}"
                         class="product-card-img">
                @else
                    <div class="product-card-img-placeholder">🛍️</div>
                @endif

                {{-- Body --}}
                <div class="product-card-body">
                    <div class="product-card-name">{{ $product->nama_produk }}</div>
                    <div class="product-card-price">Rp{{ number_format($product->harga) }}</div>
                    @if ($product->status === 'habis')
                        <span class="badge" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-size:.72rem;padding:2px 8px;border-radius:999px;margin-top:4px;display:inline-block;">Habis</span>
                    @else
                        <span class="badge" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-size:.72rem;padding:2px 8px;border-radius:999px;margin-top:4px;display:inline-block;">Tersedia</span>
                    @endif
                    @if ($product->deskripsi)
                        <p class="product-card-desc">{{ $product->deskripsi }}</p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="product-card-actions">
                    <form action="{{ route('admin.umkm.products.toggleStatus', [$umkm->id, $product->id]) }}"
                          method="POST" style="margin:0">
                        @csrf
                        <button type="submit" class="btn {{ $product->status === 'habis' ? 'btn-primary' : 'btn-secondary' }} btn-sm"
                                title="{{ $product->status === 'habis' ? 'Ubah ke Tersedia' : 'Ubah ke Habis' }}">
                            @if ($product->status === 'habis')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Tampilkan
                            @else
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                Sembunyikan
                            @endif
                        </button>
                    </form>
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