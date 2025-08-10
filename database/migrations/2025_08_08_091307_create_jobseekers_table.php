<?php

use App\Enums\EnglishLevel;
use App\Enums\Gender;
use App\Enums\LiveInExperience;
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
        Schema::create('jobseekers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('gender')->default(Gender::Female->value);
            $table->string('english_level')->default(EnglishLevel::Basic->value);
            $table->string('live_in_experience')->default(LiveInExperience::LessThan3Years->value);
            $table->boolean('driving_license')->default(false);
            $table->string('about_yourself')->setMaxLength(1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobseekers');
    }
};
