@extends('layout.app')

@section('title', 'Tambah UMKM')

@section('content')
<h2>Tambah UMKM</h2>

<form method="POST" action="{{ route('umkm.store') }}">
    @csrf

    <label>Nama UMKM</label><br>
    <input type="text" name="nama_umkm"><br><br>

    <label>Pemilik</label><br>
    <input type="text" name="pemilik"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi"></textarea><br><br>

    <label>Kontak</label><br>
    <input type="text" name="kontak"><br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"></textarea><br><br>

    <button type="submit">Simpan</button>
</form>
@endsection
