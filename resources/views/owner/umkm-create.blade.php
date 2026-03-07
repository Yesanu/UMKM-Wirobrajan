@extends('layout.owner')

@section('title', 'Daftarkan UMKM — Dashboard Pemilik')
@section('header', 'Daftarkan UMKM')

@section('content')

<div class="page-header" style="margin-bottom:20px;">
    <div>
        <div class="page-header-title">Daftarkan UMKM Baru</div>
        <div class="page-header-sub">Isi informasi usaha Anda untuk mulai berjualan</div>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('owner.storeUmkm') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="nama_umkm">Nama UMKM</label>
            <input type="text" id="nama_umkm" name="nama_umkm" value="{{ old('nama_umkm') }}" placeholder="Nama usaha Anda" class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="pemilik">Nama Pemilik</label>
            <input type="text" id="pemilik" name="pemilik" value="{{ old('pemilik', auth()->user()->name) }}" class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="tipe_umkm">Tipe UMKM</label>
            <select id="tipe_umkm" name="tipe_umkm" class="form-select">
                <option value="">— Pilih tipe usaha —</option>
                @foreach ($tipeOptions as $option)
                    <option value="{{ $option }}" {{ old('tipe_umkm') === $option ? 'selected' : '' }}>{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi Usaha</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Ceritakan tentang usaha Anda…" class="form-textarea">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="kontak">Kontak (WhatsApp)</label>
            <input type="text" id="kontak" name="kontak" value="{{ old('kontak') }}" placeholder="08123456789" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap usaha" class="form-textarea">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="logo">Logo UMKM</label>
            <input type="file" id="logo" name="logo" accept="image/*" class="form-file">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Daftarkan UMKM
            </button>
        </div>
    </form>
</div>

@endsection
