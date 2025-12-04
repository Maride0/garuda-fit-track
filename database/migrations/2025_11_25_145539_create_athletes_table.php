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
        Schema::create('athletes', function (Blueprint $table) {
            $table->string('athlete_id', 50)->primary(); // custom PK (string)
            
            // Informasi dasar atlet
            $table->string('name');                      // nama atlet
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthdate')->nullable();

            // Kontak opsional
            $table->string('contact')->nullable();

            // Cabang olahraga
            $table->string('sport_category');            // olympic / non_olympic
            $table->string('sport');                     // nama cabang olahraga

            // Informasi fisik opsional
            $table->float('height')->nullable();
            $table->float('weight')->nullable();

            // Status atlet terkait pemeriksaan/medis
            $table->enum('status', [
                'not_screened',     // atlet baru
                'fit',              // aman
                'under_monitoring', // ada masalah, dibatasi / dipantau
                'active_therapy',   // lagi ikut program terapi
                'restricted',       // benar-benar dibatasi (no play / no train)
            ])->default('not_screened');

            // 🔥 NEW — Informasi screening
            $table->date('last_screening_date')->nullable();   // screening terakhir
            $table->date('next_screening_due')->nullable();    // screening berikutnya

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
