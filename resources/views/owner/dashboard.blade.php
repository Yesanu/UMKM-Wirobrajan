@extends('layout.owner')

@section('title', 'Dashboard Pemilik')
@section('header', 'Dashboard')

@section('content')

@if (!$umkm)
    {{-- No UMKM yet --}}
    <div class="empty-state">
        <div class="empty-state-icon">🏪</div>
        <div class="empty-state-title">Anda belum memiliki UMKM</div>
        <div class="empty-state-text">Daftarkan usaha Anda untuk mulai berjualan.</div>
        <a href="{{ route('owner.createUmkm') }}" class="btn btn-primary" style="margin-top:16px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Daftarkan UMKM
        </a>
    </div>
@else
    {{-- Store Status --}}
    <div class="owner-status-bar status-{{ $umkm->status }}">
        <div>
            <strong>Status Toko:</strong>
            @switch ($umkm->status)
                @case('aktif')
                    <span class="owner-status-badge badge-aktif">✅ Aktif</span>
                    @break
                @case('pending')
                    <span class="owner-status-badge badge-pending">⏳ Menunggu Verifikasi</span>
                    @break
                @case('nonaktif')
                    <span class="owner-status-badge badge-nonaktif">⛔ Nonaktif</span>
                    @break
            @endswitch
        </div>
        @if ($umkm->status !== 'pending')
            <form method="POST" action="{{ route('owner.toggleStoreStatus') }}">
                @csrf
                <button type="submit" class="btn btn-sm {{ $umkm->status === 'aktif' ? 'btn-secondary' : 'btn-primary' }}">
                    {{ $umkm->status === 'aktif' ? 'Nonaktifkan Toko' : 'Aktifkan Toko' }}
                </button>
            </form>
        @endif
    </div>

    {{-- Stats --}}
    <div class="stat-grid" style="margin-top:20px;">
        <div class="stat-card">
            <div class="stat-number">{{ $umkm->products()->count() }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $umkm->products()->where('status','tersedia')->count() }}</div>
            <div class="stat-label">Tersedia</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $umkm->products()->where('status','habis')->count() }}</div>
            <div class="stat-label">Habis</div>
        </div>
    </div>

    {{-- Quick Info --}}
    <div class="card" style="padding:24px;margin-top:20px;">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
            <div style="flex-shrink:0;">
                @if ($umkm->logo)
                    <img src="{{ str_starts_with($umkm->logo, 'http') ? $umkm->optimized_logo : asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->nama_umkm }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;" loading="lazy">
                @else
                    <div class="umkm-logo-placeholder" style="width:64px;height:64px;font-size:1.5rem;">{{ mb_substr($umkm->nama_umkm, 0, 1) }}</div>
                @endif
            </div>
            <div>
                @if ($umkm->tipe_umkm) <span class="badge-tipe">{{ $umkm->tipe_umkm }}</span> @endif
                <h2 style="margin:4px 0 2px;font-size:1.1rem;">{{ $umkm->nama_umkm }}</h2>
                <p style="color:var(--text-muted);font-size:.85rem;margin:0;">{{ $umkm->pemilik }} • {{ $umkm->kontak ?? 'Belum ada kontak' }}</p>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('owner.editUmkm') }}" class="btn btn-secondary btn-sm">Edit Toko</a>
                <a href="{{ route('owner.products') }}" class="btn btn-primary btn-sm">Kelola Produk</a>
            </div>
        </div>
    </div>

@endif

@endsection
