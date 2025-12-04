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
        Schema::create('performance_metrics', function (Blueprint $table) {
            // PK string kayak MET0001
            $table->string('metric_id', 50)->primary();

            $table->string('name', 100);
            $table->string('code', 100)->nullable(); // SPRINT_20M, VO2MAX, dll

            // Optional: enum kategori olahraga (silakan adjust nilainya kalau kamu udah punya standar sendiri)
            $table->enum('sport_category', ['olympic', 'non_olympic', 'para_sport', 'other'])
                ->nullable();

            $table->string('sport', 100)->nullable(); // misal: "Panahan", "Bola Basket", "Umum"

            $table->string('default_unit', 20); // misal: s, cm, kg, ml/kg/min, points
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
