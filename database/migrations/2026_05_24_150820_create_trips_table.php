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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('destination');
            $table->string('departure_city');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('duration_days');
            $table->bigInteger('price');
            $table->smallInteger('quota');
            $table->smallInteger('min_participants')->default(1);
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft', 'published', 'full', 'cancelled', 'completed'])->default('draft');
            $table->string('meeting_point')->nullable();
            $table->json('includes')->nullable();
            $table->json('excludes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
