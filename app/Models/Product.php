<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_HABIS    = 'habis';
    const STATUS_NONAKTIF = 'nonaktif';

    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'harga',
        'deskripsi',
        'status',
        'foto',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function isTersedia(): bool
    {
        return $this->status === self::STATUS_TERSEDIA;
    }
}
