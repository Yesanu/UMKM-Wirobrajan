@extends('layout.app')

@section('title', 'Produk - ' . $umkm->nama_umkm)

@section('content')

<a href="{{ route('umkm.index') }}">← Kembali ke UMKM</a>
<hr>

<h2>Produk milik: {{ $umkm->nama_umkm }}</h2>

<a href="{{ route('umkm.products.create', $umkm->id) }}">
    + Tambah Produk
</a>

<hr>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@forelse ($products as $product)
    <div style="
        border:1px solid #ddd;
        padding:15px;
        border-radius:8px;
        width:220px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        ">

        @if ($product->foto)
        <img src="{{ asset('storage/'.$product->foto) }}"
         width="120"
         style="display:block; margin-bottom:10px;">
        
        @else
        <img src="https://via.placeholder.com/120x120?text=No+Image"
         width="120"
         style="display:block; margin-bottom:10px;">

        @endif


        <strong>{{ $product->nama_produk }}</strong><br>
        <span style="color:green;">
            Rp{{ number_format($product->harga) }}
        </span><br><br>
        <small>{{ $product->deskripsi }}</small><br><br>

        <a href="{{ route('umkm.products.edit', [$umkm->id, $product->id]) }}">
            Edit
        </a>

        <form action="{{ route('umkm.products.destroy', [$umkm->id, $product->id]) }}"
              method="POST"
              style="display:inline">
            @csrf
            @method('DELETE')
            
            <button onclick="return confirm('Yakin hapus produk ini?')">
                Hapus
            </button>
        </form>
    </div>

@empty
    <p>Belum ada produk.</p>
@endforelse

    <div style="margin-top:20px;">
    {{ $products->links() }}
    </div>

@endsection
