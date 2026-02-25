<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Umkm;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $umkm1 = Umkm::where('nama_umkm', 'UMKM Makanan Sehat')->first();
        $umkm2 = Umkm::where('nama_umkm', 'UMKM Kerajinan Kayu')->first();

        Product::create([
            'umkm_id'     => $umkm1->id,
            'nama_produk' => 'Salad Buah',
            'harga'       => 15000,
            'deskripsi'   => 'Salad buah segar tanpa pengawet',
        ]);

        Product::create([
            'umkm_id'     => $umkm1->id,
            'nama_produk' => 'Nasi Merah Organik',
            'harga'       => 20000,
            'deskripsi'   => 'Nasi merah sehat',
        ]);

        Product::create([
            'umkm_id'     => $umkm2->id,
            'nama_produk' => 'Meja Kayu Jati',
            'harga'       => 750000,
            'deskripsi'   => 'Meja kayu jati handmade',
        ]);
    }
}
