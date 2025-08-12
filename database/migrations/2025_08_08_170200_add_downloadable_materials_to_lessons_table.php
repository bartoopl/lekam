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
        Schema::table('lessons', function (Blueprint $table) {
            $table->json('downloadable_materials')->nullable(); // Array of downloadable files
            $table->integer('download_timer_minutes')->default(0); // Timer after download
            $table->boolean('requires_download_completion')->default(false); // Whether lesson requires download
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['downloadable_materials', 'download_timer_minutes', 'requires_download_completion']);
        });
    }
};
