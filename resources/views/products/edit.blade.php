@extends('layout.app')

@section('title', 'Edit Produk')

@section('content')

<a href="{{ route('umkm.products.index', $umkm->id) }}">← Kembali</a>
<hr>

<h2>Edit Produk - {{ $umkm->nama_umkm }}</h2>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('umkm.products.update', [$umkm->id, $product->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if ($product->foto)
    <p>Foto saat ini:</p>
    <img src="{{ asset('storage/'.$product->foto) }}"
         width="120"
         style="display:block; margin-bottom:10px;">
    @endif

    <label>Nama Produk</label><br>
    <input type="text" name="nama_produk"
           value="{{ old('nama_produk', $product->nama_produk) }}"><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga"
           value="{{ old('harga', $product->harga) }}"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi">{{ old('deskripsi', $product->deskripsi) }}</textarea><br><br>

    <input type="file" name="foto">

    <button type="submit">Update Produk</button>
</form>

@endsection
