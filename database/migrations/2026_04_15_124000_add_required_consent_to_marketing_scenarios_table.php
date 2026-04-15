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
        Schema::table('marketing_scenarios', function (Blueprint $table) {
            $table->enum('required_consent', ['consent_1', 'consent_2', 'consent_3'])
                ->default('consent_2')
                ->after('target_course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_scenarios', function (Blueprint $table) {
            $table->dropColumn('required_consent');
        });
    }
};
