<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UmkmSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UmkmSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}
