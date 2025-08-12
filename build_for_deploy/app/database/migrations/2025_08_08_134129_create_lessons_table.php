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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable(); // Plik do pobrania
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->boolean('requires_file_download')->default(false);
            $table->integer('download_wait_minutes')->default(0); // Czas oczekiwania po pobraniu
            $table->boolean('is_first_lesson')->default(false);
            $table->boolean('is_last_lesson')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
