@extends('layout.app')

@section('title', 'Tambah Produk')

@section('content')
<a href="{{ route('umkm.products.index', $umkm->id) }}">← Kembali</a>
<hr>

<h2>Tambah Produk untuk {{ $umkm->nama_umkm }}</h2>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('umkm.products.store', $umkm->id) }}" enctype="multipart/form-data">
    @csrf

    <label>Nama Produk</label><br>
    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" value="{{ old('harga') }}"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi">{{ old('deskripsi') }}</textarea><br><br>

    <input type="file" name="foto">

    <button type="submit">Simpan Produk</button>
</form>
@endsection
