<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Athlete;
use App\Models\TrainingProgram;
use Carbon\Carbon;

class TrainingProgramSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // Ambil CABOR YANG ADA AJA
        // =========================
        $sports = Athlete::query()
            ->whereNotNull('sport')
            ->where('sport', '!=', '')
            ->distinct()
            ->pluck('sport');

        if ($sports->isEmpty()) {
            return;
        }

        // Mapping kategori olahraga (cukup yg relevan)
        $olympicSports = [
            'Tenis Meja',
            'Berkuda',
            'Anggar',
            'Bola Basket',
            'Panahan',
            'Sepak Bola',
        ];

        // base tanggal biar konsisten
        $baseStart = Carbon::now()->startOfMonth()->subMonth();

        foreach ($sports as $index => $sport) {
            $sportCategory = in_array($sport, $olympicSports, true)
                ? 'olympic'
                : 'non_olympic';

            // =========================
            // Program Mingguan
            // =========================
            $startWeekly = $baseStart->copy()->addWeeks($index);
            $endWeekly   = $startWeekly->copy()->addWeeks(6);

            TrainingProgram::updateOrCreate(
                [
                    'sport'      => $sport,
                    'name'       => "Program Mingguan {$sport}",
                    'start_date' => $startWeekly->toDateString(),
                ],
                [
                    'sport_category'    => $sportCategory,
                    'type'             => 'weekly',
                    'intensity'        => 'medium',
                    'planned_sessions' => 12,
                    'team_name'        => $this->teamName($sport),
                    'coach_name'       => "Pelatih {$sport}",
                    'end_date'         => $endWeekly->toDateString(),
                    'goal'             => "Meningkatkan teknik dasar dan konsistensi latihan {$sport}.",
                    'status'           => 'active',
                ]
            );

            // =========================
            // Program Pra-Kompetisi
            // =========================
            $startPre = $endWeekly->copy()->addDays(3);
            $endPre   = $startPre->copy()->addWeeks(4);

            TrainingProgram::updateOrCreate(
                [
                    'sport'      => $sport,
                    'name'       => "Program Pra-Kompetisi {$sport}",
                    'start_date' => $startPre->toDateString(),
                ],
                [
                    'sport_category'    => $sportCategory,
                    'type'             => 'pre_competition',
                    'intensity'        => 'high',
                    'planned_sessions' => 16,
                    'team_name'        => $this->teamName($sport),
                    'coach_name'       => "Pelatih {$sport}",
                    'end_date'         => $endPre->toDateString(),
                    'goal'             => "Mempersiapkan atlet {$sport} menuju performa puncak kompetisi.",
                    'status'           => 'draft',
                ]
            );
        }
    }

    private function teamName(string $sport): ?string
    {
        $teamSports = [
            'Bola Basket',
            'Sepak Bola',
            'Esport',
        ];

        return in_array($sport, $teamSports, true)
            ? "Tim {$sport}"
            : null;
    }
}
