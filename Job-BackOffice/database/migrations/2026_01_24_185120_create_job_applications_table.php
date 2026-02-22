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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->float('aiGeneratedScore', 8, 2)->default(0);
            $table->longText('aigeneratedFeedback')->nullable();

            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('resume_id')->nullable()->references('id')->on('resumes')->onDelete('cascade');
            $table->foreignUuid('job_vacancy_id')->references('id')->on('job_vacancies')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
