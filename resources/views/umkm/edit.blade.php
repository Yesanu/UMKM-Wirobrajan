@extends('layout.app')

@section('title', 'Edit UMKM')

@section('content')

<h2>Edit UMKM</h2>

<form method="POST" action="{{ route('umkm.update', $umkm->id) }}">
    @csrf
    @method('PUT')

    <label>Nama UMKM</label><br>
    <input v type="text" name="nama_umkm" value="{{ old('nama_umkm', $umkm->nama_umkm) }}"><br><br>

    <label>Pemilik</label><br>
    <input type="text" name="pemilik" value="{{ old('pemilik', $umkm->pemilik) }}"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi">{{ old('deskripsi', $umkm->deskripsi) }}</textarea><br><br>

    <label>Kontak</label><br>
    <input type="text" name="kontak" value="{{ old('kontak', $umkm->kontak) }}"><br><br>

    <label>Alamat</label><br>
    <textarea name="alamat">{{ old('alamat', $umkm->alamat) }}</textarea><br><br>

    <button type="submit">Update</button>
</form>

@endsection