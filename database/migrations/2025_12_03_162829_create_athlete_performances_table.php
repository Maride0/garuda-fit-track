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
        Schema::create('athlete_performances', function (Blueprint $table) {
            $table->id();

            // Relasi ke athletes (PK string kayak ATH0001)
            $table->string('athlete_id', 50);

            // Relasi ke performance_metrics.metric_id
            $table->string('metric_id', 50);

            // Optional: relasi ke training_programs.program_id
            $table->string('training_program_id', 50)->nullable();

            $table->date('test_date');

            // optional fase (baseline, pre, mid, post)
            $table->enum('phase', ['baseline', 'pre', 'mid', 'post', 'other'])
                ->nullable();

            // nilai hasil tes
            $table->decimal('value', 8, 2);

            // bisa override default_unit kalau perlu (kalau null, nanti di view pakai default_unit dari metric)
            $table->string('unit', 20)->nullable();

            // sumber data (field_test, lab_test, match_data, dll)
            $table->string('source', 50)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            // Index untuk query grafik
            $table->index(['athlete_id', 'test_date']);
            $table->index(['metric_id', 'test_date']);
            $table->index('training_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athlete_performances');
    }
};
