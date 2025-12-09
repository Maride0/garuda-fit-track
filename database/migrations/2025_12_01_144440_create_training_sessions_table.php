<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();

            // Relasi ke training_programs (string PK)
            $table->string('program_id', 50);

            // ───────────── BASIC SESSION INFO ─────────────
            $table->date('date');                    // Tanggal sesi
            $table->time('start_time')->nullable();  // Waktu mulai
            $table->time('end_time')->nullable();    // Waktu berakhir (opsional)

            // durasi (menit) — sesuai UI: 60 / 90 / 120 etc
            $table->unsignedSmallInteger('duration_minutes')->nullable();

            // Lokasi sesi latihan
            $table->string('location')->nullable();

            // Catatan / aktivitas latihan
            $table->text('activities_notes')->nullable();

            // ───────────── SESSION STATUS ─────────────
            // scheduled, on_going, completed, cancelled
            $table->enum('status', ['scheduled', 'on_going', 'completed', 'cancelled'])
                ->default('scheduled');

            // Alasan pembatalan (opsional)
            $table->string('cancel_reason')->nullable();

            $table->timestamps();

            // Index buat query jadwal (future/past)
            $table->index('date');

            // Foreign key
            $table->foreign('program_id')
                  ->references('program_id')->on('training_programs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
