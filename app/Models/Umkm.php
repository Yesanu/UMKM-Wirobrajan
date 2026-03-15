<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    const TIPE_OPTIONS = [
        'Makanan & Minuman',
        'Kerajinan & Handmade',
        'Fashion & Pakaian',
        'Jasa',
        'Pertanian & Peternakan',
        'Lainnya',
    ];

    const STATUS_PENDING  = 'pending';
    const STATUS_AKTIF    = 'aktif';
    const STATUS_NONAKTIF = 'nonaktif';

    protected $fillable = [
        'user_id',
        'nama_umkm',
        'pemilik',
        'deskripsi',
        'kontak',
        'alamat',
        'logo',
        'tipe_umkm',
        'status',
    ];

    // ── Relationships ──

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ── Helpers ──

    public function isAktif(): bool
    {
        return $this->status === self::STATUS_AKTIF;
    }

    public function activeProducts()
    {
        return $this->products()->where('status', Product::STATUS_TERSEDIA);
    }

    /**
     * Get the Cloudinary-optimized logo URL (resized to 200px, auto quality/format).
     */
    public function getOptimizedLogoAttribute(): ?string
    {
        return self::optimizeCloudinaryUrl($this->logo, 'w_200,q_auto,f_auto');
    }

    /**
     * Insert Cloudinary transformations into a Cloudinary URL.
     */
    public static function optimizeCloudinaryUrl(?string $url, string $transforms): ?string
    {
        if (!$url || !str_contains($url, 'cloudinary')) {
            return $url;
        }

        // Insert transforms after /upload/ (and after version if present)
        return preg_replace(
            '#(/upload/)(?:v\d+/)?#',
            '$1' . $transforms . '/',
            $url
        );
    }
}
