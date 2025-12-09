<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_metrics', function (Blueprint $table) {
            // PK string: MET0001
            $table->id(); // auto increment PK
            $table->string('name', 100);
            $table->string('code', 100)->nullable(); // SPRINT_20M, VO2MAX, dll

            // ⬇️ Rubah dari ENUM ke STRING biar fleksibel
            //    Nilainya dikontrol lewat Form + Seeder saja
            $table->string('sport_category', 50)->nullable(); 
            // olympic / non_olympic

            $table->string('sport', 100)->nullable(); // misal: Panahan, Atletik, Esport, dll

            $table->string('default_unit', 20); // s, cm, kg, %, points, dst.
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
