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
            // 1) Master utama
            UsersTableSeeder::class,
            AthletesTableSeeder::class,
            PerformanceMetricSeeder::class,

            // 2) Program + assignment atlet ke program (sesuai cabor)
            TrainingProgramSeeder::class,
            AssignAthletesToTrainingProgramsSeeder::class,

            // 3) Jadwal program (1 bulan ke depan mulai minggu depan)
            TrainingSessionSeeder::class,

            // 4) Modul lain
            AthleteAchievementsSeeder::class,
            HealthScreeningsTableSeeder::class,
            TherapySchedulesTableSeeder::class,
            ExpenseSeeder::class,

            // 5) Data yang ngikut program/metric
            TestRecordSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
