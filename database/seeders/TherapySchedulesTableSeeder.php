<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TherapySchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('therapy_schedules')->delete();
        
        \DB::table('therapy_schedules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'athlete_id' => 'ATH0002',
                'health_screening_id' => 'SCR0001',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Core strengthening + lumbar stability + stretching hip–hamstring',
                'therapist_name' => 'dr. Rani Pramesti, Sp.KFR',
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-20',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari latihan jumping sampai minggu pertama terapi selesai.
Fokus ke latihan dressage teknik ringan dan kontrol postur.
Eval lumbar mobility di minggu ke-2 terapi untuk mencegah recurrent strain.',
                'created_at' => '2025-12-09 04:19:34',
                'updated_at' => '2025-12-09 04:19:34',
            ),
            1 => 
            array (
                'id' => 2,
                'athlete_id' => 'ATH0001',
                'health_screening_id' => 'SCR0002',
                'parent_therapy_schedule_id' => NULL,
            'therapy_type' => 'Terapi bahu (rotator cuff strengthening, mobilisasi sendi, koreksi postur)',
                'therapist_name' => 'dr. Fisio Dian Pramesti, Sp.KFR',
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-09',
                'frequency' => 3,
                'status' => 'completed',
                'progress' => 100,
                'notes' => 'Kurangi latihan yang melibatkan power smash selama 1–2 minggu. Fokus pada footwork & kontrol bola.
Evaluasi bahu selama terapi minggu ke-2 untuk mencegah impingement.',
                'created_at' => '2025-12-09 04:22:10',
                'updated_at' => '2025-12-09 04:45:20',
            ),
            2 => 
            array (
                'id' => 3,
                'athlete_id' => 'ATH0003',
                'health_screening_id' => 'SCR0003',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Ankle strengthening + balance training + proprioception + taping saat latihan',
                'therapist_name' => 'dr. Yusuf Ramadhani, Sp.KFR',
                'start_date' => '2025-12-03',
                'end_date' => '2025-12-24',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari sparring dan tendangan yang memerlukan pivot kuat.
Disarankan latihan shadowing & teknik non-impact selama minggu pertama terapi.
Evaluasi range of motion ankle minggu ke-2.',
                'created_at' => '2025-12-09 04:24:59',
                'updated_at' => '2025-12-09 04:24:59',
            ),
            3 => 
            array (
                'id' => 4,
                'athlete_id' => 'ATH0004',
                'health_screening_id' => 'SCR0004',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Knee stabilization therapy + quadriceps & hamstring strengthening',
                'therapist_name' => 'dr. Kevin Rahmat, Sp.KFR',
                'start_date' => '2025-12-04',
                'end_date' => '2025-12-26',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari sparring, checking, dan teep power selama 7 hari pertama terapi.
Boleh lakukan shadowboxing & teknik non-impact.
Evaluasi tracking patella minggu ke-2 untuk mencegah overuse injury berulang.',
                'created_at' => '2025-12-09 04:30:09',
                'updated_at' => '2025-12-09 04:30:09',
            ),
            4 => 
            array (
                'id' => 5,
                'athlete_id' => 'ATH0005',
                'health_screening_id' => 'SCR0005',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Patellofemoral pain rehabilitation',
                'therapist_name' => 'dr. Siti Ramadhani, Sp.KFR',
                'start_date' => '2025-12-05',
                'end_date' => '2025-12-27',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari lunging eksplosif selama 1–2 minggu.
Prioritaskan latihan footwork ringan & teknik garis.
Koreksi pola lutut saat lunge karena terlihat sedikit inward tracking.',
                'created_at' => '2025-12-09 04:32:10',
                'updated_at' => '2025-12-09 04:32:10',
            ),
            5 => 
            array (
                'id' => 6,
                'athlete_id' => 'ATH0006',
                'health_screening_id' => 'SCR0006',
                'parent_therapy_schedule_id' => NULL,
            'therapy_type' => 'Ankle rehabilitation (balance board, proprioception, calf strength)',
                'therapist_name' => 'dr. Rahma Nurdin, Sp.KFR',
                'start_date' => '2025-12-06',
                'end_date' => '2025-12-27',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari latihan yang melibatkan sprint dan cutting keras selama 1 minggu.
Boleh latihan shooting statis & passing drill.
Lakukan proprioception test di minggu ke-2 untuk lihat stabilitas ankle.',
                'created_at' => '2025-12-09 04:34:18',
                'updated_at' => '2025-12-09 04:34:18',
            ),
            6 => 
            array (
                'id' => 7,
                'athlete_id' => 'ATH0007',
                'health_screening_id' => 'SCR0007',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Wrist physiotherapy + nerve gliding + ergonomic correction',
                'therapist_name' => 'dr. Antonius Prabowo, Sp.KFR',
                'start_date' => '2025-12-07',
                'end_date' => '2025-12-28',
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Disarankan memakai wrist rest, angle mouse lebih rendah, dan break tiap 45 menit.
Lakukan stretching forearm 3x sehari.
Evaluasi nerve gliding response di minggu kedua.',
                'created_at' => '2025-12-09 04:36:18',
                'updated_at' => '2025-12-09 04:36:18',
            ),
            7 => 
            array (
                'id' => 8,
                'athlete_id' => 'ATH0008',
                'health_screening_id' => 'SCR0008',
                'parent_therapy_schedule_id' => NULL,
                'therapy_type' => 'Patellar tendon rehab: eccentric squat, hip–knee alignment correction, quad strengthening',
                'therapist_name' => 'dr. M. Ridwan Prasetyo, Sp.KFR',
                'start_date' => '2025-12-04',
                'end_date' => NULL,
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Hindari latihan eksplosif seperti jumping & sprinting selama minggu pertama terapi.
Boleh latihan shooting statis dan passing drill.
Evaluasi tracking lutut (knee valgus) di minggu ke-2.',
                'created_at' => '2025-12-09 04:38:19',
                'updated_at' => '2025-12-09 04:38:19',
            ),
            8 => 
            array (
                'id' => 9,
                'athlete_id' => 'ATH0009',
                'health_screening_id' => 'SCR0009',
                'parent_therapy_schedule_id' => NULL,
            'therapy_type' => 'Rotator cuff strengthening (band external rotation) Scapular stability training Postural correction untuk menjaga alignment saat drawing Soft tissue release area supraspinatus',
                'therapist_name' => 'dr. Aldo Wiratmaja, Sp.KFR',
                'start_date' => '2025-12-05',
                'end_date' => '2025-12-26',
                'frequency' => 3,
                'status' => 'completed',
                'progress' => 100,
                'notes' => 'Hindari latihan >150 arrow/day sampai minggu pertama terapi selesai.
Fokus ke teknik drawing pelan, bukan power.
Perhatikan scapular retraction saat draw — terlihat sedikit tidak stabil.',
                'created_at' => '2025-12-09 04:41:57',
                'updated_at' => '2025-12-09 04:46:23',
            ),
            9 => 
            array (
                'id' => 10,
                'athlete_id' => 'ATH0010',
                'health_screening_id' => 'SCR0010',
                'parent_therapy_schedule_id' => NULL,
            'therapy_type' => 'Hamstring rehab (eccentric Nordic curl) Hip stability strengthening Soft tissue release + stretching Gradual return-to-sprint protocol',
                'therapist_name' => 'dr. Fakhri Rahmat, Sp.KFR',
                'start_date' => '2025-12-08',
                'end_date' => NULL,
                'frequency' => 3,
                'status' => 'planned',
                'progress' => 0,
                'notes' => 'Tidak boleh sprint atau explosive movement selama 1 minggu.
Boleh jogging ringan jika tidak menambah nyeri.
Sprint progression dimulai minggu ke-2 (50% → 70% → 90%).',
                'created_at' => '2025-12-09 04:44:05',
                'updated_at' => '2025-12-09 04:44:05',
            ),
        ));
        
        
    }
}