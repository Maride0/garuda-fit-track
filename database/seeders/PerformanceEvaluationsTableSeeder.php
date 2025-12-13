<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PerformanceEvaluationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('performance_evaluations')->delete();
        
        \DB::table('performance_evaluations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'athlete_id' => 'ATH0006',
                'training_program_id' => 'TPR0010',
                'evaluation_date' => '2025-12-08',
                'overall_rating' => 84,
                'discipline_score' => 100,
                'attendance_score' => 96,
                'effort_score' => 45,
                'attitude_score' => 78,
                'tactical_understanding_score' => 100,
                'coach_notes' => NULL,
                'created_by' => NULL,
                'metric_id' => NULL,
                'value_numeric' => NULL,
                'value_label' => NULL,
                'created_at' => '2025-12-08 12:23:23',
                'updated_at' => '2025-12-08 12:23:23',
            ),
            1 => 
            array (
                'id' => 3,
                'athlete_id' => 'ATH0107',
                'training_program_id' => 'TPR0009',
                'evaluation_date' => '2025-01-14',
                'overall_rating' => 92,
                'discipline_score' => 100,
                'attendance_score' => 100,
                'effort_score' => 80,
                'attitude_score' => 79,
                'tactical_understanding_score' => 100,
                'coach_notes' => NULL,
                'created_by' => NULL,
                'metric_id' => NULL,
                'value_numeric' => NULL,
                'value_label' => NULL,
                'created_at' => '2025-12-08 12:30:20',
                'updated_at' => '2025-12-08 12:30:57',
            ),
            2 => 
            array (
                'id' => 12,
                'athlete_id' => 'ATH0008',
                'training_program_id' => 'TPR0010',
                'evaluation_date' => '2025-12-12',
                'overall_rating' => 100,
                'discipline_score' => 100,
                'attendance_score' => 100,
                'effort_score' => 100,
                'attitude_score' => 100,
                'tactical_understanding_score' => 100,
                'coach_notes' => NULL,
                'created_by' => NULL,
                'metric_id' => 14,
                'value_numeric' => '58.00',
                'value_label' => 'Stabil dari jarak 45°',
                'created_at' => '2025-12-12 20:27:52',
                'updated_at' => '2025-12-12 20:27:52',
            ),
        ));
        
        
    }
}