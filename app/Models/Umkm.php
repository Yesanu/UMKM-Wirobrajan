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
}
