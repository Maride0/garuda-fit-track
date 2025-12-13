<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TrainingProgramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('training_programs')->delete();
        
        \DB::table('training_programs')->insert(array (
            0 => 
            array (
                'program_id' => 'TPR0001',
                'name' => 'Sprint Conditioning Phase 1',
                'type' => 'weekly',
                'type_other' => NULL,
                'intensity' => 'high',
                'sport_category' => 'olympic',
                'sport' => 'Atletik',
                'team_name' => 'Track Elite A',
                'coach_name' => 'Coach Andika',
                'start_date' => '2025-01-05',
                'end_date' => '2025-02-02',
                'planned_sessions' => 5,
                'goal' => 'Meningkatkan akselerasi dan top speed untuk musim kompetisi.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'program_id' => 'TPR0002',
                'name' => 'Daily Endurance Swim Block',
                'type' => 'daily',
                'type_other' => NULL,
                'intensity' => 'medium',
                'sport_category' => 'olympic',
                'sport' => 'Renang',
                'team_name' => 'Shark Squad',
                'coach_name' => 'Coach Liana',
                'start_date' => '2025-01-10',
                'end_date' => '2025-01-24',
                'planned_sessions' => 6,
                'goal' => 'Meningkatkan VO2max dan daya tahan renang 400m.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'program_id' => 'TPR0003',
                'name' => 'Archery Pre-Tournament Prep',
                'type' => 'pre_competition',
                'type_other' => NULL,
                'intensity' => 'high',
                'sport_category' => 'olympic',
                'sport' => 'Panahan',
                'team_name' => 'Eagle Archers',
                'coach_name' => 'Coach Surya',
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-20',
                'planned_sessions' => 12,
                'goal' => 'Memaksimalkan akurasi tembakan menjelang turnamen utama.',
                'status' => 'draft',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'program_id' => 'TPR0004',
                'name' => 'Shoulder Recovery Block',
                'type' => 'recovery',
                'type_other' => NULL,
                'intensity' => 'low',
                'sport_category' => 'olympic',
                'sport' => 'Bulutangkis',
                'team_name' => 'Smash Heroes',
                'coach_name' => 'Physio Rani',
                'start_date' => '2025-01-15',
                'end_date' => '2025-02-05',
                'planned_sessions' => 8,
                'goal' => 'Rehabilitasi bahu kanan pasca overuse.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'program_id' => 'TPR0005',
                'name' => 'Aim Precision Routine',
                'type' => 'weekly',
                'type_other' => NULL,
                'intensity' => 'medium',
                'sport_category' => 'non_olympic',
                'sport' => 'Esport',
                'team_name' => 'Valkyrie Esports',
                'coach_name' => 'Coach Ryu',
                'start_date' => '2025-01-08',
                'end_date' => '2025-02-08',
                'planned_sessions' => 10,
                'goal' => 'Meningkatkan reaction time dan akurasi aim.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'program_id' => 'TPR0006',
                'name' => 'Muay Thai Power Striking Program',
                'type' => 'daily',
                'type_other' => NULL,
                'intensity' => 'high',
                'sport_category' => 'non_olympic',
                'sport' => 'Muay Thai',
                'team_name' => 'Tiger Camp',
                'coach_name' => 'Kru Somchai',
                'start_date' => '2025-01-20',
                'end_date' => '2025-02-03',
                'planned_sessions' => 14,
                'goal' => 'Meningkatkan power tendangan dan kombinasi pukulan cepat.',
                'status' => 'draft',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'program_id' => 'TPR0007',
                'name' => 'Synchronized Swim Formation Routine',
                'type' => 'weekly',
                'type_other' => NULL,
                'intensity' => 'medium',
                'sport_category' => 'olympic',
                'sport' => 'Renang Indah',
                'team_name' => 'Aqua Harmony',
                'coach_name' => 'Coach Felicia',
                'start_date' => '2025-02-05',
                'end_date' => '2025-03-05',
                'planned_sessions' => 6,
                'goal' => 'Menyempurnakan transisi formasi dan sinkronisasi tim.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'program_id' => 'TPR0008',
                'name' => 'Taekwondo Sparring Peak Phase',
                'type' => 'pre_competition',
                'type_other' => NULL,
                'intensity' => 'high',
                'sport_category' => 'olympic',
                'sport' => 'Taekwondo',
                'team_name' => 'Dragon TKD',
                'coach_name' => 'Master Hwang',
                'start_date' => '2025-01-28',
                'end_date' => '2025-02-18',
                'planned_sessions' => 16,
                'goal' => 'Meningkatkan agility, timing, dan akurasi scoring.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'program_id' => 'TPR0009',
                'name' => 'Wushu Flexibility Recovery',
                'type' => 'recovery',
                'type_other' => NULL,
                'intensity' => 'low',
                'sport_category' => 'non_olympic',
                'sport' => 'Wushu',
                'team_name' => 'Phoenix Wushu',
                'coach_name' => 'Coach Ning',
                'start_date' => '2025-01-02',
                'end_date' => '2025-01-15',
                'planned_sessions' => 5,
                'goal' => 'Mengurangi tightness pada hamstring & pinggul.',
                'status' => 'completed',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'program_id' => 'TPR0010',
                'name' => 'Basketball Tactical Rotation Drill',
                'type' => 'weekly',
                'type_other' => NULL,
                'intensity' => 'medium',
                'sport_category' => 'olympic',
                'sport' => 'Bola Basket',
                'team_name' => 'Hoop Warriors',
                'coach_name' => 'Coach Randy',
                'start_date' => '2025-01-12',
                'end_date' => '2025-02-02',
                'planned_sessions' => 8,
                'goal' => 'Meningkatkan rotasi defense dan ball movement.',
                'status' => 'active',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}