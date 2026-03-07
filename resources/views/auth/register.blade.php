@extends('layout.public')

@section('title', 'Daftar — UMKM Wirobrajan')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
            </div>
            <h1 class="auth-title">Buat Akun</h1>
            <p class="auth-subtitle">Bergabunglah dengan UMKM Wirobrajan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Nama lengkap Anda"
                       class="form-input" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Minimal 8 karakter"
                       class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Ulangi password"
                       class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Daftar Sebagai</label>
                <div class="role-picker">
                    <label class="role-option {{ old('role', 'user') === 'user' ? 'active' : '' }}">
                        <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                        <div class="role-option-icon">🛒</div>
                        <div class="role-option-label">Pembeli</div>
                        <div class="role-option-desc">Jelajahi & beli produk UMKM</div>
                    </label>
                    <label class="role-option {{ old('role') === 'pemilik' ? 'active' : '' }}">
                        <input type="radio" name="role" value="pemilik" {{ old('role') === 'pemilik' ? 'checked' : '' }}>
                        <div class="role-option-icon">🏪</div>
                        <div class="role-option-label">Pemilik UMKM</div>
                        <div class="role-option-desc">Kelola toko & produk Anda</div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px;">
                Daftar
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.role-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('active'));
            this.closest('.role-option').classList.add('active');
        });
    });
</script>
@endsection
