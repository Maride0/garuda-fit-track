<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_programs', function (Blueprint $table) {
            // ─────────────────────────────────────────────
            // PRIMARY KEY STRING (BUKAN auto increment)
            // ─────────────────────────────────────────────
            $table->string('program_id', 50)->primary();

            // ─────────────────────────────────────────────
            // BASIC INFO
            // ─────────────────────────────────────────────
            $table->string('name'); // Nama program

            // Tipe Program
            $table->enum('type', [
                'daily',
                'weekly',
                'pre_competition',
                'recovery',
                'testing_only',
                'other',
            ])->default('weekly');

            // Untuk tipe program custom / lainnya
            $table->string('type_other')->nullable();

            // Intensitas (Low, Medium, High)
            $table->enum('intensity', ['low', 'medium', 'high'])
                  ->default('medium');

            // Kategori olahraga      
            $table->string('sport_category');            // olympic / non_olympic
      
            // Sport / cabang olahraga (opsional)
            $table->string('sport');

            // Tim dan pelatih (string dulu, nanti bisa dipindah ke tabel lain)
            $table->string('team_name')->nullable();
            $table->string('coach_name')->nullable();

            // ─────────────────────────────────────────────
            // PERIODE
            // ─────────────────────────────────────────────
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Total sesi rencana
            $table->unsignedInteger('planned_sessions')->nullable();

            // Tujuan / deskripsi program
            $table->text('goal')->nullable();

            // ─────────────────────────────────────────────
            // STATUS PROGRAM
            // (Mirip medical flow kamu: draft → active → completed)
            // ─────────────────────────────────────────────
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])
                  ->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
