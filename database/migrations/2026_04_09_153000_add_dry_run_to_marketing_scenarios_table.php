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
            $table->boolean('dry_run')
                ->default(true)
                ->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_scenarios', function (Blueprint $table) {
            $table->dropColumn('dry_run');
        });
    }
};
