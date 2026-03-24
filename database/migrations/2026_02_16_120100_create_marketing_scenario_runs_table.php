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
        Schema::create('marketing_scenario_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_scenario_id')->constrained('marketing_scenarios')->cascadeOnDelete();
            $table->dateTime('scheduled_for');
            $table->dateTime('dispatched_at')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['marketing_scenario_id', 'scheduled_for']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_scenario_runs');
    }
};
