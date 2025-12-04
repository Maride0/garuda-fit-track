<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('athlete_training_program', function (Blueprint $table) {
            $table->id();

            // FK ke athlete
            $table->string('athlete_id', 50);

            // FK ke training program
            $table->string('program_id', 50);

            // Info tambahan pivot
            $table->enum('status', ['active', 'dropped', 'completed'])
                ->default('active');

            $table->string('role')->nullable(); // starter / rehab / reserve
            $table->date('join_date')->nullable();

            $table->timestamps();

            // 🔗 RELASI PENTING (FK)
            $table->foreign('athlete_id')
                  ->references('athlete_id')->on('athletes')
                  ->onDelete('cascade');

            $table->foreign('program_id')
                  ->references('program_id')->on('training_programs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('athlete_training_program');
    }
};
