<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Matikan FK biar seeding nggak error
        Schema::disableForeignKeyConstraints();

        $this->call([
            // --- Master Data & Athlete Base ---
            AthletesTableSeeder::class,
            AthleteFillAllSportsSeeder::class,

            // --- Performance & Achievements ---
            AchievementsTableSeeder::class,
            AthleteAchievementsSeeder::class,
            PerformanceMetricSeeder::class,

            // --- Training ---
            TrainingProgramSeeder::class,
            TrainingSessionSeeder::class,

            // --- Finance ---
            ExpenseSeeder::class,

            // --- Health & Therapy (HARUS terakhir) ---
            HealthScreeningsTableSeeder::class,
            TherapySchedulesTableSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
