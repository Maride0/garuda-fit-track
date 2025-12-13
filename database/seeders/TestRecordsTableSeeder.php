<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestRecordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('test_records')->delete();
        
        \DB::table('test_records')->insert(array (
            0 => 
            array (
                'id' => 6,
                'athlete_id' => 'ATH0008',
                'metric_id' => '14',
                'training_program_id' => 'TPR0010',
                'test_date' => '2025-12-12',
                'phase' => 'post',
                'source_type' => NULL,
                'source_id' => NULL,
                'value' => '58.00',
                'unit' => NULL,
                'source' => 'Program Evaluation',
                'notes' => NULL,
                'created_at' => '2025-12-12 20:27:52',
                'updated_at' => '2025-12-12 20:27:52',
            ),
        ));
        
        
    }
}