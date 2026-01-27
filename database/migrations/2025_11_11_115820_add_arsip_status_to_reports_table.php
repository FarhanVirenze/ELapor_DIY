<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (menambah enum 'Arsip')
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Tambahkan kembali 'Arsip' ke daftar enum status
            $table->enum('status', [
                'Diajukan',
                'Dibaca',
                'Direspon',
                'Selesai',
                'Revisi',
                'Arsip'
            ])->default('Diajukan')->change();
        });
    }

    /**
     * Rollback migrasi (hapus enum 'Arsip' jika dibatalkan)
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Hapus 'Arsip' dari daftar enum (kembali ke sebelumnya)
            $table->enum('status', [
                'Diajukan',
                'Dibaca',
                'Direspon',
                'Selesai',
                'Revisi'
            ])->default('Diajukan')->change();
        });
    }
};
