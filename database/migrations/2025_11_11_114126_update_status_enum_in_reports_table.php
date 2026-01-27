<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // 1️⃣ Ubah enum dulu — tambahkan 'Revisi', hapus 'Arsip'
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Revisi', 'Arsip'])
                  ->default('Diajukan')
                  ->change();
        });

        // 2️⃣ Sekarang update datanya dengan aman
        DB::table('reports')->where('status', 'Arsip')->update(['status' => 'Revisi']);

        // 3️⃣ Lalu ubah enum lagi, hapus 'Arsip' dari daftar
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Revisi'])
                  ->default('Diajukan')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Tambahkan 'Arsip' kembali sementara agar rollback tidak error
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Revisi', 'Arsip'])
                  ->default('Diajukan')
                  ->change();
        });

        DB::table('reports')->where('status', 'Revisi')->update(['status' => 'Arsip']);

        Schema::table('reports', function (Blueprint $table) {
            // Kembalikan enum seperti semula (hapus 'Revisi')
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Arsip'])
                  ->default('Diajukan')
                  ->change();
        });
    }
};
