@extends('layout.owner')

@section('title', ($product ? 'Edit' : 'Tambah') . ' Produk — Dashboard Pemilik')
@section('header', ($product ? 'Edit' : 'Tambah') . ' Produk')

@section('content')

<a href="{{ route('owner.products') }}" class="back-link">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Daftar Produk
</a>

<div class="page-header" style="margin-bottom:20px;">
    <div>
        <div class="page-header-title">{{ $product ? 'Edit Produk' : 'Tambah Produk Baru' }}</div>
        <div class="page-header-sub">{{ $umkm->nama_umkm }}</div>
    </div>
</div>

<div class="form-card">
    <form method="POST"
          action="{{ $product ? route('owner.updateProduct', $product->id) : route('owner.storeProduct') }}"
          enctype="multipart/form-data">
        @csrf
        @if ($product) @method('PUT') @endif

        @if ($product && $product->foto)
            <div class="form-group">
                <label class="form-label">Foto Saat Ini</label>
                <div class="preview-wrap">
                    <img src="{{ str_starts_with($product->foto, 'http') ? $product->foto : asset('storage/'.$product->foto) }}" alt="{{ $product->nama_produk }}" class="preview-img">
                </div>
            </div>
        @endif

        <div class="form-group">
            <label class="form-label" for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk"
                   value="{{ old('nama_produk', $product->nama_produk ?? '') }}"
                   placeholder="Nama produk"
                   class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga"
                   value="{{ old('harga', $product->harga ?? '') }}"
                   placeholder="0"
                   class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi produk…" class="form-textarea">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="foto">{{ $product ? 'Ganti Foto' : 'Upload Foto' }}</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-file">
            <p style="font-size:.78rem;color:var(--text-muted);margin-top:5px;">Format: JPG, PNG. Maks 2 MB.</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ $product ? 'Simpan Perubahan' : 'Simpan Produk' }}
            </button>
            <a href="{{ route('owner.products') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection
