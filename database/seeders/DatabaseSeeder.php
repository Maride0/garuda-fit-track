<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // =========================
        // 1) MASTER / BASE
        // =========================
        $this->call([
            UsersTableSeeder::class,
            AthletesTableSeeder::class,

            // master parameter/metric dulu sebelum test record
            PerformanceMetricSeeder::class,

            // master program dulu sebelum pivot & sessions
            TrainingProgramSeeder::class,
        ]);

        // =========================
        // 2) RELASI ATLET <-> PROGRAM (PIVOT)
        // =========================
        $this->call([
            AssignAthletesToTrainingProgramsSeeder::class,
        ]);

        // nyalain FK lagi biar error kebaca jelas di seeder bawah
        Schema::enableForeignKeyConstraints();

        // =========================
        // 3) TURUNAN DARI PROGRAM / ATLET
        // =========================
        $this->call([
            // jadwal latihan (bergantung pada program)
            TrainingSessionSeeder::class,

            // prestasi (bergantung pada atlet)
            AthleteAchievementsSeeder::class,

            // kesehatan & terapi (bergantung pada atlet)
            HealthScreeningsTableSeeder::class,
            TherapySchedulesTableSeeder::class,

            // pengeluaran (bergantung pada atlet / sistem kamu)
            ExpenseSeeder::class,
        ]);

        // =========================
        // 4) TURUNAN DARI PROGRAM + METRIC (+ PIVOT)
        // =========================
        $this->call([
            TestRecordSeeder::class,
        ]);

        // OPTIONAL / LEGACY (jangan dipanggil barengan kalau isinya duplikat)
        // $this->call([
        //     AchievementsTableSeeder::class,
        //     TrainingSessionsTableSeeder::class,
        // ]);
    }
}
