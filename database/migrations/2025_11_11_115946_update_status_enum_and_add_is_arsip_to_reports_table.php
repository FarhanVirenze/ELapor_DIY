<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum 'status' dan tambahkan kolom 'is_arsip'
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Revisi', 'Arsip'])
                  ->default('Diajukan')
                  ->change();

            if (!Schema::hasColumn('reports', 'is_arsip')) {
                $table->boolean('is_arsip')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        // Kembalikan ke enum sebelumnya dan hapus kolom is_arsip
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Revisi'])
                  ->default('Diajukan')
                  ->change();

            if (Schema::hasColumn('reports', 'is_arsip')) {
                $table->dropColumn('is_arsip');
            }
        });
    }
};
