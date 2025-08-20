<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix lessons that require download completion but have no timer set
        DB::table('lessons')
            ->where('requires_download_completion', true)
            ->where('download_timer_minutes', 0)
            ->update(['download_timer_minutes' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert timer changes
        DB::table('lessons')
            ->where('requires_download_completion', true)
            ->where('download_timer_minutes', 2)
            ->update(['download_timer_minutes' => 0]);
    }
};
