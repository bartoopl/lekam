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
            $table->enum('trigger_type', ['inactive_users', 'incomplete_course'])
                ->default('incomplete_course')
                ->after('description');
            $table->unsignedInteger('inactivity_days')
                ->default(7)
                ->after('trigger_type');
            $table->foreignId('target_course_id')
                ->nullable()
                ->after('inactivity_days')
                ->constrained('courses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_scenarios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('target_course_id');
            $table->dropColumn('inactivity_days');
            $table->dropColumn('trigger_type');
        });
    }
};
