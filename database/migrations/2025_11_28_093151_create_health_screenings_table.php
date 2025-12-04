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
        Schema::create('health_screenings', function (Blueprint $table) {

            $table->string('screening_id', 20)->primary();

            // OPTIONAL — internal counter untuk generator yang konsisten
            $table->unsignedBigInteger('auto_increment')->unique();

            // Foreign Key to athletes
            $table->string('athlete_id', 50);

            // follow-up therapy ID (no FK to avoid circular relation)
            $table->unsignedBigInteger('follow_up_therapy_schedule_id')->nullable();
            $table->date('screening_date');
            $table->enum('exam_type', [
                'routine',
                'injury',
                'follow_up',
                'competition',
            ]);

            $table->enum('screening_result', [
                'fit',
                'restricted',
                'requires_therapy',
                'active_therapy',
            ]);

            $table->boolean('is_locked')->default(false);
            $table->timestamp('finalized_at')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('respiration_rate')->nullable();
            $table->integer('oxygen_saturation')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('injury_history')->nullable();
            $table->string('pain_location')->nullable();
            $table->integer('pain_scale')->nullable();
            $table->string('training_load')->nullable();
            $table->string('training_frequency')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->foreign('athlete_id')
                  ->references('athlete_id')
                  ->on('athletes')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_screenings');
    }
};
