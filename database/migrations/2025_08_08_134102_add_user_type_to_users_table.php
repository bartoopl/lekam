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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['technik_farmacji', 'farmaceuta'])->default('technik_farmacji');
            $table->string('license_number')->nullable(); // Numer licencji
            $table->text('bio')->nullable(); // Krótki opis użytkownika
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'license_number', 'bio']);
        });
    }
};
