<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            // PK custom (kalau kamu nanti mau auto-generate ACH0001, dll)
            $table->string('achievement_id', 50)->primary();

            // Relasi ke athlete
            $table->string('athlete_id', 50);
            $table
                ->foreign('athlete_id')
                ->references('athlete_id')
                ->on('athletes')
                ->cascadeOnDelete();

            /*
             * SECTION 1: Informasi Kegiatan
             */
            $table->string('event_name'); // Nama Event

            $table->enum('competition_level', [
                'international',        // Internasional
                'continental',          // Kontinental
                'national',             // Nasional
                'provincial',           // Provinsi
                'city_regional_club',   // Kota / Regional / Klub
            ]);

            $table->string('organizer');   // Penyelenggara
            $table->string('location')->nullable();
            $table->date('start_date');    // Tanggal Mulai
            $table->date('end_date');      // Tanggal Selesai

            /*
             * SECTION 2: Informasi Prestasi
             */
            $table->string('achievement_name');            // Nama Prestasi
            $table->string('event_number')->nullable();    // Nomor Pertandingan / Event
            $table->text('notes')->nullable();             // Notes / Catatan (opsional)

            $table->string('evidence_file')->nullable();   // path file bukti

            /*
             * SECTION 3: Detail Prestasi
             */
            $table->enum('medal_rank', [
                'gold',        // Gold
                'silver',      // Silver
                'bronze',      // Bronze
                'non_podium',  // No Medal / Non-podium
            ])->default('non_podium');

            $table->unsignedSmallInteger('rank')->nullable(); // peringkat
            $table->string('result')->nullable();             // skor / waktu / jarak

            $table->timestamps();

            $table->index('athlete_id');
            $table->index('competition_level');
            $table->index('medal_rank');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};