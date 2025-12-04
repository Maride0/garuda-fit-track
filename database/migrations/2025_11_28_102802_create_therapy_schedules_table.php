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
        Schema::create('therapy_schedules', function (Blueprint $table) {
            $table->id();

            // Relasi ke athletes (PK string)
            $table->string('athlete_id', 50);

            // Relasi ke health_screenings (PK string: screening_id)
            $table->string('health_screening_id', 20)->nullable();

            // Optional: self-reference
            // parent_therapy_schedule_id = terapi induk yang sedang di-follow up / lanjutan
            $table->unsignedBigInteger('parent_therapy_schedule_id')->nullable();

            // Informasi terapi
            $table->string('therapy_type');             // contoh: "Fisioterapi Lutut"
            $table->string('therapist_name')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('frequency')->nullable(); // contoh: 4 = review / screening ulang 4 minggu lagi
            
            // Status terapi
            $table->enum('status', [
                'planned',   // sudah dijadwalkan
                'active',    // sedang berlangsung
                'completed', // selesai
                'cancelled', // dibatalkan
            ])->default('planned');

            $table->unsignedTinyInteger('progress')->default(0); // 0–100 %

            // Catatan tambahan
            $table->text('notes')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEYS
            |--------------------------------------------------------------------------
            */

            $table->foreign('athlete_id')
                  ->references('athlete_id')
                  ->on('athletes')
                  ->cascadeOnDelete();

            // SEKARANG refer ke screening_id (string), bukan id
            $table->foreign('health_screening_id')
                  ->references('screening_id')
                  ->on('health_screenings')
                  ->nullOnDelete();

            $table->foreign('parent_therapy_schedule_id')
                  ->references('id')
                  ->on('therapy_schedules')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapy_schedules');
    }
};
