@extends('layout.app')

@section('title', 'Edit Produk — ' . $product->nama_produk)
@section('header', 'Edit Produk')

@section('content')

<a href="{{ route('admin.umkm.products.index', $umkm->id) }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Produk {{ $umkm->nama_umkm }}
</a>

<div class="page-header" style="margin-bottom:20px;">
    <div>
        <div class="page-header-title">Edit: {{ $product->nama_produk }}</div>
        <div class="page-header-sub">UMKM: <strong>{{ $umkm->nama_umkm }}</strong></div>
    </div>
</div>

<div class="form-card">
    <form method="POST"
          action="{{ route('admin.umkm.products.update', [$umkm->id, $product->id]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Current Photo Preview --}}
        @if ($product->foto)
            <div class="form-group">
                <label class="form-label">Foto Saat Ini</label>
                <div class="preview-wrap">
                    <img src="{{ asset('storage/'.$product->foto) }}"
                         alt="{{ $product->nama_produk }}"
                         class="preview-img">
                    <div class="preview-label">
                        <strong>Foto aktif</strong>
                        Upload baru untuk mengganti
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group">
            <label class="form-label" for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk"
                   value="{{ old('nama_produk', $product->nama_produk) }}"
                   class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga"
                   value="{{ old('harga', $product->harga) }}"
                   min="0" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      class="form-textarea">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="foto">{{ $product->foto ? 'Ganti Foto' : 'Upload Foto' }}</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-file">
            <p style="font-size:.78rem;color:var(--text-muted);margin-top:5px;">
                Format: JPG, PNG, GIF. Kosongkan jika tidak ingin mengganti.
            </p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.umkm.products.index', $umkm->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection