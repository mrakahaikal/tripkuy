<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('highlight', 160)->nullable()->after('description');
            $table->enum('difficulty_level', ['easy', 'moderate', 'hard'])->default('moderate')->after('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('payment_deadline')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['highlight', 'difficulty_level']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('payment_deadline');
        });
    }
};
