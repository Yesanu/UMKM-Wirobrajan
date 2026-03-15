<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes on frequently queried columns.
     */
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->index('status');
            $table->index('tipe_umkm');
            $table->index('user_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('umkm_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tipe_umkm']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['umkm_id']);
            $table->dropIndex(['status']);
        });
    }
};
