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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignUuid('jobseeker_id')->constrained('jobseekers')->cascadeOnDelete();
            $table->unique(['job_id', 'jobseeker_id']); // osiguravamo da se može prijaviti jednom na isti posao
            $table->text('cover_letter')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

