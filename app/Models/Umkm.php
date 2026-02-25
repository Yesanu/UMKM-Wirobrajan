<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_umkm',
        'pemilik',
        'deskripsi',
        'kontak',
        'alamat',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
