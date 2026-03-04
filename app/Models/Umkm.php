<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Umkm extends Model
{
    use HasFactory;

    /**
     * Available UMKM type options.
     */
    const TIPE_OPTIONS = [
        'Makanan & Minuman',
        'Kerajinan & Handmade',
        'Fashion & Pakaian',
        'Jasa',
        'Pertanian & Peternakan',
        'Lainnya',
    ];

    protected $fillable = [
        'nama_umkm',
        'pemilik',
        'deskripsi',
        'kontak',
        'alamat',
        'logo',
        'tipe_umkm',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
