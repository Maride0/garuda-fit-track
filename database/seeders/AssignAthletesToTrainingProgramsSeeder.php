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
        $programs = TrainingProgram::query()->get();
        if ($programs->isEmpty()) return;

        // Pilih pivot table yang ada (kalau relasinya many-to-many)
        $pivotCandidates = [
            'athlete_training_program',       // common
            'athlete_training_programs',
            'athlete_training_program_pivot',
            'athlete_training_programs_pivot',
            'athlete_training_programs_map',
            'athlete_training_program_map',
            'athlete_training_programs_links',
            'athlete_training_program_links',
            'athlete_training_programs_relations',
            'athlete_training_program_relations',
            'athlete_training_programs_assignments',
            'athlete_training_program_assignments',
            'athlete_training_programs_members',
            'athlete_training_program_members',
            'training_program_athlete',       // common reverse
            'training_program_athletes',
        ];

        $pivotTable = null;
        foreach ($pivotCandidates as $t) {
            if (Schema::hasTable($t)) { $pivotTable = $t; break; }
        }

        // Kalau gak ada pivot table, kemungkinan relasinya one-to-many lewat kolom di athletes
        // (mis: athletes.training_program_id). Kita juga detect itu.
        $athletesHasProgramId = Schema::hasColumn('athletes', 'training_program_id');

        foreach ($programs as $program) {
            // ambil atlet yang cabornya sama
            $athletes = Athlete::query()
                ->where('sport', $program->sport)
                ->get();

            if ($athletes->isEmpty()) continue;

            if ($pivotTable) {
                // Deteksi nama kolom pivot
                $cols = Schema::getColumnListing($pivotTable);

                $athleteKey = in_array('athlete_id', $cols, true) ? 'athlete_id'
                            : (in_array('athlete_uuid', $cols, true) ? 'athlete_uuid' : 'athlete_id');

                $programKey = in_array('training_program_id', $cols, true) ? 'training_program_id'
                            : (in_array('program_id', $cols, true) ? 'program_id' : 'training_program_id');

                foreach ($athletes as $athlete) {
                    // idempotent: avoid duplicate
                    $exists = DB::table($pivotTable)
                        ->where($athleteKey, $athlete->athlete_id)
                        ->where($programKey, $program->training_program_id ?? $program->id)
                        ->exists();

                    if (! $exists) {
                        DB::table($pivotTable)->insert([
                            $athleteKey => $athlete->athlete_id,
                            $programKey => $program->training_program_id ?? $program->id,
                        ]);
                    }
                }
            } elseif ($athletesHasProgramId) {
                // one-to-many: set athletes.training_program_id = program id
                Athlete::query()
                    ->where('sport', $program->sport)
                    ->update(['training_program_id' => $program->training_program_id ?? $program->id]);
            } else {
                // Kalau struktur kamu beda, seeder gak bisa assign — tapi test record masih bisa link ke program nanti.
                // (Kita tetap jalanin seeder TestRecord.)
            }
        }
    }
}
