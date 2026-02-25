<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        Umkm::create([
            'nama_umkm' => 'UMKM Makanan Sehat',
            'pemilik'   => 'Ibu Sari',
            'deskripsi' => 'Menjual makanan sehat rumahan',
            'kontak'    => '081234567890',
            'alamat'    => 'Wirobrajan, Yogyakarta',
        ]);

        Umkm::create([
            'nama_umkm' => 'UMKM Kerajinan Kayu',
            'pemilik'   => 'Pak Budi',
            'deskripsi' => 'Kerajinan kayu handmade',
            'kontak'    => '082345678901',
            'alamat'    => 'Wirobrajan, Yogyakarta',
        ]);
    }
}