@extends('layout.app')

@section('title', 'Tambah UMKM')
@section('header', 'Tambah UMKM')

@section('content')

<a href="{{ route('umkm.index') }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Daftar UMKM
</a>

<div class="page-header" style="margin-bottom:20px;">
    <div>
        <div class="page-header-title">Tambah UMKM Baru</div>
        <div class="page-header-sub">Lengkapi informasi usaha di bawah ini</div>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('umkm.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="nama_umkm">Nama UMKM</label>
            <input type="text" id="nama_umkm" name="nama_umkm"
                   value="{{ old('nama_umkm') }}"
                   placeholder="Contoh: Warung Makan Bu Sari"
                   class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="pemilik">Nama Pemilik</label>
            <input type="text" id="pemilik" name="pemilik"
                   value="{{ old('pemilik') }}"
                   placeholder="Nama lengkap pemilik usaha"
                   class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="tipe_umkm">Tipe UMKM</label>
            <select id="tipe_umkm" name="tipe_umkm" class="form-select">
                <option value="">— Pilih tipe usaha —</option>
                @foreach ($tipeOptions as $option)
                    <option value="{{ $option }}" {{ old('tipe_umkm') === $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi Usaha</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      placeholder="Ceritakan secara singkat tentang usaha ini…"
                      class="form-textarea">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="kontak">Kontak</label>
            <input type="text" id="kontak" name="kontak"
                   value="{{ old('kontak') }}"
                   placeholder="Nomor HP / WhatsApp"
                   class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"
                      placeholder="Alamat lengkap usaha"
                      class="form-textarea">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="logo">Logo UMKM</label>
            <input type="file" id="logo" name="logo" accept="image/*" class="form-file">
            <p style="font-size:.78rem;color:var(--text-muted);margin-top:5px;">
                Format: JPG, PNG, GIF. Ukuran maks. 2 MB.
            </p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan UMKM
            </button>
            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection