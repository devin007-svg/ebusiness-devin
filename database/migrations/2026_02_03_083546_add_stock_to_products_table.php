<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu: kalau kolom stock belum ada, baru tambahkan
        if (!Schema::hasColumn('products', 'stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('stock')->default(0)->after('price');
            });
        }
    }

    public function down(): void
    {
        // Drop hanya kalau kolomnya memang ada
        if (Schema::hasColumn('products', 'stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('stock');
            });
        }
    }
};
