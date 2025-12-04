<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus default user factory kalau nggak dipakai
        // User::factory(10)->create();

        // Panggil semua seeder yang kamu mau jalankan
        $this->call([
            // AthletesTableSeeder::class,
            // AchievementsTableSeeder::class,
            // TrainingProgramSeeder::class,
            ExpenseSeeder::class,
        ]);
    }
    
}
