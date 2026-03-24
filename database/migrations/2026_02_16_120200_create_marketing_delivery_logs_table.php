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
        Schema::create('marketing_delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_scenario_id')->constrained('marketing_scenarios')->cascadeOnDelete();
            $table->foreignId('marketing_scenario_run_id')->constrained('marketing_scenario_runs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('channel', ['email', 'sms']);
            $table->enum('status', ['queued', 'sent', 'failed', 'skipped'])->default('queued');
            $table->string('provider_message_id')->nullable();
            $table->text('error_message')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['marketing_scenario_run_id', 'user_id', 'channel'], 'marketing_delivery_unique_per_run');
            $table->index(['marketing_scenario_id', 'channel', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_delivery_logs');
    }
};
