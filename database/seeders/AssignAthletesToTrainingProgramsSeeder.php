<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Athlete;
use App\Models\TrainingProgram;

class AssignAthletesToTrainingProgramsSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua program (harus sudah di-seed)
        $programs = TrainingProgram::query()->get();
        if ($programs->isEmpty()) {
            // Tidak ada program -> tidak ada yang bisa di-assign
            return;
        }

        // =========================
        // DETEKSI PIVOT TABLE
        // =========================
        $pivotCandidates = [
            'athlete_training_program', // default kamu
            'athlete_training_programs',
            'training_program_athlete',
            'training_program_athletes',
        ];

        $pivotTable = null;
        foreach ($pivotCandidates as $t) {
            if (Schema::hasTable($t)) {
                $pivotTable = $t;
                break;
            }
        }

        // =========================
        // DETEKSI ONE-TO-MANY FALLBACK
        // =========================
        $athletesHasProgramId =
            Schema::hasTable('athletes') &&
            Schema::hasColumn('athletes', 'training_program_id');

        // Kalau ada pivot table, pastikan kolomnya bisa dideteksi
        $athleteKey = null;
        $programKey = null;

        if ($pivotTable) {
            $cols = Schema::getColumnListing($pivotTable);

            // kolom athlete FK yang mungkin
            if (in_array('athlete_id', $cols, true)) {
                $athleteKey = 'athlete_id';
            } elseif (in_array('athlete_uuid', $cols, true)) {
                $athleteKey = 'athlete_uuid';
            } else {
                // fallback aman: tetap pakai athlete_id
                $athleteKey = 'athlete_id';
            }

            // kolom program FK yang mungkin
            if (in_array('program_id', $cols, true)) {
                $programKey = 'program_id';
            } elseif (in_array('training_program_id', $cols, true)) {
                $programKey = 'training_program_id';
            } else {
                // fallback aman: tetap pakai program_id
                $programKey = 'program_id';
            }
        }

        // =========================
        // ASSIGN PER PROGRAM -> ATLET SESUAI CABOR
        // =========================
        foreach ($programs as $program) {
            // Ambil PK program yang BENAR (apa pun namanya: id / program_id / training_program_id)
            $programPk = $program->getKey();

            // Guard: kalau somehow null, skip biar gak error DB
            if (! $programPk) {
                continue;
            }

            // Ambil atlet yang cabornya sama
            // (Asumsi: athletes.sport dan training_programs.sport sama formatnya)
            $athletes = Athlete::query()
                ->where('sport', $program->sport)
                ->get();

            if ($athletes->isEmpty()) {
                continue;
            }

            // =========================
            // CASE A: MANY-TO-MANY via PIVOT
            // =========================
            if ($pivotTable) {
                foreach ($athletes as $athlete) {
                    $athletePk = $athlete->athlete_id;

                    // Guard: kalau athlete id null (harusnya nggak), skip
                    if (! $athletePk) {
                        continue;
                    }

                    // idempotent: jangan duplikat
                    $exists = DB::table($pivotTable)
                        ->where($athleteKey, $athletePk)
                        ->where($programKey, $programPk)
                        ->exists();

                    if (! $exists) {
                        DB::table($pivotTable)->insert([
                            $athleteKey => $athletePk,
                            $programKey => $programPk,
                            // kalau pivot kamu ada timestamps, uncomment:
                            // 'created_at' => now(),
                            // 'updated_at' => now(),
                        ]);
                    }
                }

                continue;
            }

            // =========================
            // CASE B: ONE-TO-MANY lewat athletes.training_program_id
            // =========================
            if ($athletesHasProgramId) {
                Athlete::query()
                    ->where('sport', $program->sport)
                    ->update(['training_program_id' => $programPk]);

                continue;
            }

            // =========================
            // CASE C: STRUKTUR TIDAK TERDETEKSI
            // =========================
            // kalau struktur kamu beda, seeder ini tidak melakukan apa-apa.
            // (lebih baik silent daripada bikin data salah / error)
        }
    }
}
