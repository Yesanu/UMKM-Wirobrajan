@extends('layout.app')

@section('title', 'Daftar UMKM')

@section('content')

<a href="{{ route('umkm.create') }}">+ Tambah UMKM</a>
<hr>

    @forelse ($umkms as $umkm)
        <div style="margin-bottom: 20px;">
            <h2>{{ $umkm->nama_umkm }}</h2>
            <p><strong>Pemilik:</strong> {{ $umkm->pemilik }}</p>
            <p>{{ $umkm->deskripsi }}</p>

            <h4>Produk:</h4>
            <a href="{{ route('umkm.products.index', $umkm->id) }}">Kelola Produk</a>
            
            <ul>
                @forelse ($umkm->products as $product)
                    <li>
                        {{ $product->nama_produk }} — 
                        Rp{{ number_format($product->harga) }}
                    </li>
                @empty
                    <li>Belum ada produk</li>
                @endforelse
            </ul>

            <a href="{{ route('umkm.edit', $umkm->id) }}">Edit</a>

        <form action="{{ route('umkm.destroy', $umkm->id) }}"
              method="POST"
              style="display:inline">

            @csrf
            @method('DELETE')

            <button type="submit"
                onclick="return confirm('Yakin hapus UMKM ini?')">
                Hapus
            </button>
        </form>
        <hr>
        </div>
    @empty
        <p>Tidak ada data UMKM</p>
    @endforelse

@endsection
