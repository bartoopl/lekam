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
            $table->string('phone')->nullable()->after('email');
            $table->string('pwz_number')->nullable()->after('phone');
            $table->text('pharmacy_address')->nullable()->after('pwz_number');
            $table->string('pharmacy_postal_code')->nullable()->after('pharmacy_address');
            $table->string('pharmacy_city')->nullable()->after('pharmacy_postal_code');
            $table->string('ref')->nullable()->after('pharmacy_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
