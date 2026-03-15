<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix products with NULL status — set them to 'tersedia'
     * so they appear correctly on the public store page.
     */
    public function up(): void
    {
        DB::table('products')
            ->whereNull('status')
            ->update(['status' => 'tersedia']);
    }

    public function down(): void
    {
        // No rollback needed
    }
};
