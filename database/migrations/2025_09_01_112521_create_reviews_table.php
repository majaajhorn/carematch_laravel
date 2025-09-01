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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jobseeker_id')->constrained('jobseekers')->onDelete('cascade');
            $table->foreignUuid('employer_id')->constrained('employers')->onDelete('cascade');
            $table->unsignedTinyInteger('rating_star');
            $table->text('review_description')->nullable();
            $table->unique(['jobseeker_id', 'employer_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
