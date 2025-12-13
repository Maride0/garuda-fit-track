<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PerformanceMetricsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('performance_metrics')->delete();
        
        \DB::table('performance_metrics')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sprint 10m',
                'code' => 'SPRINT_10M',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 's',
                'description' => 'Tes akselerasi 10 meter untuk berbagai cabang olahraga.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Sprint 20m',
                'code' => 'SPRINT_20M',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 's',
                'description' => 'Tes kecepatan/akselerasi 20 meter untuk multisport.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Countermovement Jump (CMJ)',
                'code' => 'CMJ_VERTICAL_JUMP',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'cm',
                'description' => 'Tes loncat tegak untuk mengukur power eksplosif tungkai.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Standing Long Jump',
                'code' => 'STANDING_LONG_JUMP',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'cm',
                'description' => 'Tes power horizontal dari posisi berdiri.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            4 => 
            array (
                'id' => 5,
            'name' => 'VO2 Max (Beep Test)',
                'code' => 'VO2MAX_BEEP_TEST',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'ml/kg/min',
            'description' => 'Estimasi VO₂ Max menggunakan Multistage Shuttle Run (Beep Test).',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Yo-Yo Intermittent Recovery Test Level 1',
                'code' => 'YOYO_IR1',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'm',
                'description' => 'Tes daya tahan intermittent untuk berbagai cabang olahraga.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Cooper 12-Minute Run',
                'code' => 'COOPER_12MIN',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'm',
                'description' => 'Tes daya tahan aerobik umum selama 12 menit.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Flexibility - Sit & Reach',
                'code' => 'SIT_AND_REACH',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'cm',
                'description' => 'Tes fleksibilitas hamstring & punggung bawah.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Reaction Time Test',
                'code' => 'GENERIC_REACTION_TIME',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'ms',
                'description' => 'Tes waktu reaksi sederhana menggunakan alat digital.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Back Squat 1RM',
                'code' => 'BACK_SQUAT_1RM',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'kg',
                'description' => 'Pengukuran 1RM back squat untuk kekuatan tungkai.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Bench Press 1RM',
                'code' => 'BENCH_PRESS_1RM',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'kg',
                'description' => 'Pengukuran kekuatan tubuh atas via 1RM bench press.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Deadlift 1RM',
                'code' => 'DEADLIFT_1RM',
                'sport_category' => 'general',
                'sport' => NULL,
                'default_unit' => 'kg',
                'description' => 'Tes kekuatan posterior chain melalui deadlift.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Free Throw Accuracy',
                'code' => 'BASKETBALL_FREE_THROW_PCT',
                'sport_category' => 'olympic',
                'sport' => 'Bola Basket',
                'default_unit' => '%',
                'description' => 'Akurasi tembakan bebas dalam percobaan standar.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Three-Point Shooting Accuracy',
                'code' => 'BASKETBALL_3PT_PCT',
                'sport_category' => 'olympic',
                'sport' => 'Bola Basket',
                'default_unit' => '%',
                'description' => 'Persentase keberhasilan tembakan tiga angka.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Serve Speed',
                'code' => 'TENNIS_SERVE_SPEED',
                'sport_category' => 'olympic',
                'sport' => 'Tenis',
                'default_unit' => 'km/h',
                'description' => 'Kecepatan servis tenis yang diukur menggunakan radar.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => '100m Race Time',
                'code' => 'ATHLETICS_100M_TIME',
                'sport_category' => 'olympic',
                'sport' => 'Atletik',
                'default_unit' => 's',
            'description' => 'Waktu tempuh lari 100 meter (sprint).',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Archery Pull Force',
                'code' => 'ARCHERY_PULL_FORCE',
                'sport_category' => 'olympic',
                'sport' => 'Panahan',
                'default_unit' => 'kg',
                'description' => 'Gaya tarik maksimum busur panahan.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            17 => 
            array (
                'id' => 18,
            'name' => 'Aiming Accuracy (Esport)',
                'code' => 'ESPORT_AIM_ACCURACY',
                'sport_category' => 'non_olympic',
                'sport' => 'Esport',
                'default_unit' => '%',
                'description' => 'Akurasi aiming dalam pengujian in-game atau software tracking.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            18 => 
            array (
                'id' => 19,
            'name' => 'Actions Per Minute (APM)',
                'code' => 'ESPORT_APM',
                'sport_category' => 'non_olympic',
                'sport' => 'Esport',
                'default_unit' => 'actions/min',
                'description' => 'Jumlah aksi per menit sebagai indikator skill esports.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            19 => 
            array (
                'id' => 20,
            'name' => 'Kick Power (Pencak Silat)',
                'code' => 'SILAT_KICK_POWER',
                'sport_category' => 'non_olympic',
                'sport' => 'Pencak Silat',
                'default_unit' => 'N',
                'description' => 'Kekuatan tendangan dalam cabang Pencak Silat.',
                'is_active' => 1,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
        ));
        
        
    }
}