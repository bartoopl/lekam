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
            $table->boolean('consent_1')->default(false)->after('representative_id');
            $table->boolean('consent_2')->default(false)->after('consent_1');
            $table->boolean('consent_3')->default(false)->after('consent_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['consent_1', 'consent_2', 'consent_3']);
        });
    }
};
