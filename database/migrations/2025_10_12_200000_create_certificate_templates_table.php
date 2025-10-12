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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nazwa szablonu
            $table->enum('user_type', ['farmaceuta', 'technik_farmacji'])->nullable(); // Typ użytkownika (null = dla wszystkich)
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade'); // null = domyślny szablon
            $table->string('pdf_path'); // Ścieżka do PDF szablonu
            $table->json('fields_config')->nullable(); // Konfiguracja pól: pozycje X,Y, czcionka, rozmiar
            $table->integer('next_certificate_number')->default(1); // Kolejny numer certyfikatu dla tego szablonu
            $table->string('certificate_prefix')->default('CERT'); // Prefix numeracji (np. FAR, TECH)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index dla szybkiego wyszukiwania szablonu
            $table->index(['user_type', 'course_id', 'is_active']);
        });

        // Dodaj kolumnę template_id do certificates
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('certificate_template_id')->nullable()->after('course_id')->constrained('certificate_templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn('certificate_template_id');
        });

        Schema::dropIfExists('certificate_templates');
    }
};
