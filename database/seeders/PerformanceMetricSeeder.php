<?php

namespace Database\Seeders;

use App\Models\PerformanceMetric;
use Illuminate\Database\Seeder;

class PerformanceMetricSeeder extends Seeder
{
    public function run(): void
    {
        $metrics = [

            // ======================================================
            // 1) GENERAL / MULTISPORT PERFORMANCE METRICS
            // ======================================================
            [
                'name'           => 'Sprint 10m',
                'code'           => 'SPRINT_10M',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 's',
                'is_active'      => true,
                'description'    => 'Tes akselerasi 10 meter untuk berbagai cabang olahraga.',
            ],
            [
                'name'           => 'Sprint 20m',
                'code'           => 'SPRINT_20M',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 's',
                'is_active'      => true,
                'description'    => 'Tes kecepatan/akselerasi 20 meter untuk multisport.',
            ],
            [
                'name'           => 'Countermovement Jump (CMJ)',
                'code'           => 'CMJ_VERTICAL_JUMP',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'cm',
                'is_active'      => true,
                'description'    => 'Tes loncat tegak untuk mengukur power eksplosif tungkai.',
            ],
            [
                'name'           => 'Standing Long Jump',
                'code'           => 'STANDING_LONG_JUMP',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'cm',
                'is_active'      => true,
                'description'    => 'Tes power horizontal dari posisi berdiri.',
            ],
            [
                'name'           => 'VO2 Max (Beep Test)',
                'code'           => 'VO2MAX_BEEP_TEST',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'ml/kg/min',
                'is_active'      => true,
                'description'    => 'Estimasi VO₂ Max menggunakan Multistage Shuttle Run (Beep Test).',
            ],
            [
                'name'           => 'Yo-Yo Intermittent Recovery Test Level 1',
                'code'           => 'YOYO_IR1',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'm',
                'is_active'      => true,
                'description'    => 'Tes daya tahan intermittent untuk berbagai cabang olahraga.',
            ],
            [
                'name'           => 'Cooper 12-Minute Run',
                'code'           => 'COOPER_12MIN',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'm',
                'is_active'      => true,
                'description'    => 'Tes daya tahan aerobik umum selama 12 menit.',
            ],
            [
                'name'           => 'Flexibility - Sit & Reach',
                'code'           => 'SIT_AND_REACH',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'cm',
                'is_active'      => true,
                'description'    => 'Tes fleksibilitas hamstring & punggung bawah.',
            ],
            [
                'name'           => 'Reaction Time Test',
                'code'           => 'GENERIC_REACTION_TIME',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'ms',
                'is_active'      => true,
                'description'    => 'Tes waktu reaksi sederhana menggunakan alat digital.',
            ],

            // ======================================================
            // 2) STRENGTH METRICS (Tetap General)
            // ======================================================
            [
                'name'           => 'Back Squat 1RM',
                'code'           => 'BACK_SQUAT_1RM',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'kg',
                'is_active'      => true,
                'description'    => 'Pengukuran 1RM back squat untuk kekuatan tungkai.',
            ],
            [
                'name'           => 'Bench Press 1RM',
                'code'           => 'BENCH_PRESS_1RM',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'kg',
                'is_active'      => true,
                'description'    => 'Pengukuran kekuatan tubuh atas via 1RM bench press.',
            ],
            [
                'name'           => 'Deadlift 1RM',
                'code'           => 'DEADLIFT_1RM',
                'sport_category' => 'general',
                'sport'          => null,
                'default_unit'   => 'kg',
                'is_active'      => true,
                'description'    => 'Tes kekuatan posterior chain melalui deadlift.',
            ],

            // ======================================================
            // 3) OLYMPIC SPORT SPECIFIC METRICS
            // ======================================================
            [
                'name'           => 'Free Throw Accuracy',
                'code'           => 'BASKETBALL_FREE_THROW_PCT',
                'sport_category' => 'olympic',
                'sport'          => 'Bola Basket',
                'default_unit'   => '%',
                'is_active'      => true,
                'description'    => 'Akurasi tembakan bebas dalam percobaan standar.',
            ],
            [
                'name'           => 'Three-Point Shooting Accuracy',
                'code'           => 'BASKETBALL_3PT_PCT',
                'sport_category' => 'olympic',
                'sport'          => 'Bola Basket',
                'default_unit'   => '%',
                'is_active'      => true,
                'description'    => 'Persentase keberhasilan tembakan tiga angka.',
            ],
            [
                'name'           => 'Serve Speed',
                'code'           => 'TENNIS_SERVE_SPEED',
                'sport_category' => 'olympic',
                'sport'          => 'Tenis',
                'default_unit'   => 'km/h',
                'is_active'      => true,
                'description'    => 'Kecepatan servis tenis yang diukur menggunakan radar.',
            ],
            [
                'name'           => '100m Race Time',
                'code'           => 'ATHLETICS_100M_TIME',
                'sport_category' => 'olympic',
                'sport'          => 'Atletik',
                'default_unit'   => 's',
                'is_active'      => true,
                'description'    => 'Waktu tempuh lari 100 meter (sprint).',
            ],
            [
                'name'           => 'Archery Pull Force',
                'code'           => 'ARCHERY_PULL_FORCE',
                'sport_category' => 'olympic',
                'sport'          => 'Panahan',
                'default_unit'   => 'kg',
                'is_active'      => true,
                'description'    => 'Gaya tarik maksimum busur panahan.',
            ],

            // ======================================================
            // 4) NON-OLYMPIC SPORT SPECIFIC METRICS
            // ======================================================
            [
                'name'           => 'Aiming Accuracy (Esport)',
                'code'           => 'ESPORT_AIM_ACCURACY',
                'sport_category' => 'non_olympic',
                'sport'          => 'Esport',
                'default_unit'   => '%',
                'is_active'      => true,
                'description'    => 'Akurasi aiming dalam pengujian in-game atau software tracking.',
            ],
            [
                'name'           => 'Actions Per Minute (APM)',
                'code'           => 'ESPORT_APM',
                'sport_category' => 'non_olympic',
                'sport'          => 'Esport',
                'default_unit'   => 'actions/min',
                'is_active'      => true,
                'description'    => 'Jumlah aksi per menit sebagai indikator skill esports.',
            ],
            [
                'name'           => 'Kick Power (Pencak Silat)',
                'code'           => 'SILAT_KICK_POWER',
                'sport_category' => 'non_olympic',
                'sport'          => 'Pencak Silat',
                'default_unit'   => 'N',
                'is_active'      => true,
                'description'    => 'Kekuatan tendangan dalam cabang Pencak Silat.',
            ],
        ];

        foreach ($metrics as $data) {
            PerformanceMetric::updateOrCreate(
                ['code' => $data['code']],
                $data
            );
        }
    }
}
