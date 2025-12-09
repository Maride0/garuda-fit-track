<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Athlete;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AthleteAchievementsSeeder extends Seeder
{
    public function run(): void
    {
        // Cabor yang biasanya berkelompok / tim
        $teamSports = [
            'Sepak Bola',
            'Bola Basket',
            'Bola Voli',
            'Polo Air',
            'Rugby',
            'Rugby Sevens',
            'Hoki',
            'Hoki Es',
            'Cricket',
            'Dragon Boat',
            'Esport',
            'Sepak Takraw',
            'Korfball',
            'Floorball',
            'Bisbol - Sofbol',
        ];

        // Tingkat kompetisi
        $competitionLevels = [
            'international',
            'continental',
            'national',
            'provincial',
            'city_regional_club',
        ];

        $competitionLabels = [
            'international'      => 'Kejuaraan Internasional',
            'continental'        => 'Kejuaraan Kontinental',
            'national'           => 'Kejuaraan Nasional',
            'provincial'         => 'Kejuaraan Provinsi',
            'city_regional_club' => 'Kejuaraan Kota / Regional / Klub',
        ];

        // Medali & rank
        $medals = [
            ['medal_rank' => 'gold',   'rank' => 1],
            ['medal_rank' => 'silver', 'rank' => 2],
            ['medal_rank' => 'bronze', 'rank' => 3],
            ['medal_rank' => 'non_podium', 'rank' => null],
        ];

        // Lokasi contoh
        $locations = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Denpasar', 'Makassar', 'Semarang'];

        // Cari achievement_id terakhir, misal "ACH0012"
        $lastAchievementId = Achievement::max('achievement_id'); // bisa null
        $counter = $lastAchievementId
            ? (int) substr($lastAchievementId, 3)
            : 0;

        // Loop semua atlet
        $athletes = Athlete::orderBy('athlete_id')->get();

        foreach ($athletes as $index => $athlete) {
            $isTeamSport = in_array($athlete->sport, $teamSports, true);

            // Tim punya lebih banyak event
            $achievementCount = $isTeamSport ? 3 : 2;

            for ($i = 0; $i < $achievementCount; $i++) {
                $counter++;

                $achievementId = 'ACH' . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);

                // Pilih level & medal secara bergilir supaya variatif tapi deterministik
                $levelIndex = ($index + $i) % count($competitionLevels);
                $level = $competitionLevels[$levelIndex];

                $medal = $medals[($index + $i) % count($medals)];
                $medalRank = $medal['medal_rank'];
                $rank = $medal['rank'];

                $eventLabel = $competitionLabels[$level] ?? 'Kejuaraan';
                $eventName = $eventLabel . ' ' . $athlete->sport;

                // Tanggal event – kira-kira realistis dengan umur (15+ tahun ke atas)
                $birth = Carbon::parse($athlete->birthdate);
                $eventStart = $birth
                    ->copy()
                    ->addYears(15 + ($i % 5))
                    ->addMonths(($index + $i) % 12);

                // Jangan lewat hari ini
                if ($eventStart->greaterThan(now()->subMonth())) {
                    $eventStart = now()->subMonths(2)->startOfMonth();
                }

                $eventEnd = $eventStart->copy()->addDays(2 + ($i % 3));

                // Hasil (score / waktu) simple aja tapi beda antara tim & individu
                if ($isTeamSport) {
                    $result = 'Skor ' . (2 + ($i % 3)) . '–' . (1 + (($index + $i) % 2));
                } else {
                    $result = 'Waktu ' . (11 + ($index % 5)) . '.' . (20 + ($i * 3)) . ' detik';
                }

                $achievementName = match ($medalRank) {
                    'gold'   => 'Juara 1 ' . $athlete->sport,
                    'silver' => 'Juara 2 ' . $athlete->sport,
                    'bronze' => 'Juara 3 ' . $athlete->sport,
                    default  => 'Partisipasi ' . $athlete->sport,
                };

                Achievement::create([
                    'achievement_id'   => $achievementId,
                    'athlete_id'       => $athlete->athlete_id,
                    'achievement_name' => $achievementName,
                    'event_number'     => 'No. ' . ($index + 1) . '/' . ($i + 1),
                    'notes'            => "Prestasi cabang {$athlete->sport} pada {$competitionLabels[$level]}.",
                    'evidence_file'    => null, // biarin kosong, nanti bisa upload manual

                    'medal_rank'       => $medalRank,
                    'rank'             => $rank,
                    'result'           => $result,

                    'event_name'       => $eventName,
                    'competition_level'=> $level,
                    'organizer'        => 'Panitia ' . $athlete->sport,
                    'location'         => $locations[($index + $i) % count($locations)],

                    'start_date'       => $eventStart->toDateString(),
                    'end_date'         => $eventEnd->toDateString(),
                ]);
            }
        }
    }
}
