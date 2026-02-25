<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Umkm;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'harga',
        'deskripsi',
        'foto',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
