<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('priority')->nullable()->after('status')->comment('Low, Medium, High, Emergency');
            $table->string('sentiment')->nullable()->after('priority')->comment('Positive, Neutral, Negative');
            $table->text('ai_analysis')->nullable()->after('sentiment');
            $table->unsignedBigInteger('suggested_kategori_id')->nullable()->after('ai_analysis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['priority', 'sentiment', 'ai_analysis', 'suggested_kategori_id']);
        });
    }
};
