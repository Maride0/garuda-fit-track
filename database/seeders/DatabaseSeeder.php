<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            AthletesTableSeeder::class,
            TrainingProgramsTableSeeder::class,
            PerformanceMetricsTableSeeder::class,

            AthleteTrainingProgramTableSeeder::class,
            AchievementsTableSeeder::class,
            HealthScreeningsTableSeeder::class,
            TherapySchedulesTableSeeder::class,
            TrainingSessionsTableSeeder::class,
            PerformanceEvaluationsTableSeeder::class,
            TestRecordsTableSeeder::class,
            ExpensesTableSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
