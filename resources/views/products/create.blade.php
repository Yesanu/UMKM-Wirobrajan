@extends('layout.app')

@section('title', 'Tambah Produk — ' . $umkm->nama_umkm)
@section('header', 'Tambah Produk')

@section('content')

<a href="{{ route('admin.umkm.products.index', $umkm->id) }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Produk {{ $umkm->nama_umkm }}
</a>

<div class="page-header" style="margin-bottom:20px;">
    <div>
        <div class="page-header-title">Tambah Produk Baru</div>
        <div class="page-header-sub">untuk <strong>{{ $umkm->nama_umkm }}</strong></div>
    </div>
</div>

<div class="form-card">
    <form method="POST"
          action="{{ route('admin.umkm.products.store', $umkm->id) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk"
                   value="{{ old('nama_produk') }}"
                   placeholder="Contoh: Keripik Singkong Pedas"
                   class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="harga">Harga (Rp)</label>
            <input type="text" id="harga" name="harga"
                   value="{{ old('harga') }}"
                   placeholder="Contoh: 15.000"
                   inputmode="numeric"
                   min="0" class="form-input">
            <p style="font-size:.78rem;color:var(--text-muted);margin-top:5px;">Gunakan titik sebagai pemisah ribuan, contoh: 15.000</p>
        </div>

        <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      placeholder="Jelaskan keunggulan atau bahan produk ini…"
                      class="form-textarea">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="foto">Foto Produk</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-file">
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
                Simpan Produk
            </button>
            <a href="{{ route('admin.umkm.products.index', $umkm->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection