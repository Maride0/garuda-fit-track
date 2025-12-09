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

            /** ===============================
             *  RELATIONS
             *  =============================== */

            // Atlet yang dievaluasi
            $table->string('athlete_id', 50);
            $table->foreign('athlete_id')
                ->references('athlete_id')
                ->on('athletes')
                ->cascadeOnDelete();

            // Program tempat evaluasi dilakukan
            $table->string('training_program_id', 50)->nullable();
            $table->foreign('training_program_id')
                ->references('program_id')
                ->on('training_programs')
                ->cascadeOnDelete();

            /** ===============================
             *  EVALUATION DETAILS
             *  =============================== */

            // Tanggal evaluasi
            $table->date('evaluation_date')->nullable();

            // Rating utama (1–10 biasanya)
            $table->unsignedTinyInteger('overall_rating')->nullable();

            // Sub-ratings (opsional, bisa null)
            $table->unsignedTinyInteger('discipline_score')->nullable();
            $table->unsignedTinyInteger('attendance_score')->nullable();
            $table->unsignedTinyInteger('effort_score')->nullable();
            $table->unsignedTinyInteger('attitude_score')->nullable();
            $table->unsignedTinyInteger('tactical_understanding_score')->nullable();

            // Catatan tambahan dari pelatih
            $table->text('coach_notes')->nullable();

            // Optional: coach/user yang input
            $table->unsignedBigInteger('created_by')->nullable();

            /** ===============================
             *  PERFORMANCE METRICS (optional)
             *  =============================== */
            // Bisa digunakan jika coach mau attach metric tertentu dari tabel performance_metrics
            $table->unsignedBigInteger('metric_id')->nullable();
            $table->foreign('metric_id')
                ->references('id')
                ->on('performance_metrics')
                ->nullOnDelete();

            // Jika metric_id dipakai → nilai angka
            $table->decimal('value_numeric', 8, 2)->nullable();

            // Jika metric tidak numeric → label saja
            $table->string('value_label', 100)->nullable();


            $table->timestamps();

            /** INDEX SPEED-UP */
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
