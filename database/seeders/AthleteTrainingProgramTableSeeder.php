<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AthleteTrainingProgramTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('athlete_training_program')->delete();
        
        \DB::table('athlete_training_program')->insert(array (
            0 => 
            array (
                'id' => 3,
                'athlete_id' => 'ATH0006',
                'program_id' => 'TPR0010',
                'status' => 'active',
                'role' => NULL,
                'join_date' => '2025-01-03',
                'created_at' => '2025-12-08 11:23:09',
                'updated_at' => '2025-12-08 11:23:09',
            ),
            1 => 
            array (
                'id' => 4,
                'athlete_id' => 'ATH0008',
                'program_id' => 'TPR0010',
                'status' => 'active',
                'role' => NULL,
                'join_date' => '2025-01-03',
                'created_at' => '2025-12-08 11:23:23',
                'updated_at' => '2025-12-08 11:23:23',
            ),
            2 => 
            array (
                'id' => 5,
                'athlete_id' => 'ATH0107',
                'program_id' => 'TPR0009',
                'status' => 'active',
                'role' => NULL,
                'join_date' => '2024-12-23',
                'created_at' => '2025-12-08 12:29:32',
                'updated_at' => '2025-12-08 12:29:32',
            ),
        ));
        
        
    }
}