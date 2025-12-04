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
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();

            $table->string('athlete_id', 50);
            $table->string('training_program_id', 50)->nullable();

            $table->date('evaluation_date');

            // kamu bisa pakai 1–5 atau 1–10, sementara aku set tinyint
            $table->unsignedTinyInteger('overall_rating')->nullable();

            $table->unsignedTinyInteger('discipline_score')->nullable();
            $table->unsignedTinyInteger('attendance_score')->nullable();
            $table->unsignedTinyInteger('effort_score')->nullable();
            $table->unsignedTinyInteger('attitude_score')->nullable();
            $table->unsignedTinyInteger('tactical_understanding_score')->nullable();

            $table->text('coach_notes')->nullable();

            // Optional: siapa user yang input
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            $table->index('athlete_id');
            $table->index('training_program_id');
            $table->index('evaluation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
