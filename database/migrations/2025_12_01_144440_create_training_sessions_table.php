<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            // ID internal, biarin auto increment karena ini nggak ditampilin ke user
            $table->id();

            // Relasi ke training_programs (string PK)
            $table->string('program_id', 50);

            // ───────────── BASIC SESSION INFO ─────────────
            $table->date('date');                 // Tanggal sesi
            $table->time('start_time')->nullable(); // Waktu mulai

            // Durasi dalam menit (sesuai dropdown UI: 60 / 90 / 120 / dst)
            $table->unsignedSmallInteger('duration_minutes')->nullable();

            $table->string('location')->nullable(); // Lokasi latihan

            // Jumlah peserta di sesi ini (boleh null, bisa diisi manual)
            $table->unsignedSmallInteger('participants_count')->nullable();

            // Daftar aktivitas / catatan sesi (textarea "Aktivitas")
            $table->text('activities')->nullable();

            // Status sesi: terjadwal / selesai / batal
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])
                  ->default('scheduled');

            $table->timestamps();

            // Index buat query "sesi mendatang / minggu ini"
            $table->index('date');

            // Foreign key ke training_programs.program_id
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
