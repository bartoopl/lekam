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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // np. 'home.hero.title', 'about.mission'
            $table->string('title'); // Tytuł sekcji do wyświetlenia w adminie
            $table->text('content'); // Treść
            $table->string('type')->default('text'); // text, html, wysiwyg
            $table->string('page'); // home, about, contact
            $table->string('section'); // hero, features, mission, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
