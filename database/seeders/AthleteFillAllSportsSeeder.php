<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AthleteFillAllSportsSeeder extends Seeder
{
    public function run(): void
    {
        // Semua cabor sesuai schema form
        $olympicSports = [
            'Anggar',
            'Angkat Besi',
            'Atletik',
            'Balap Sepeda',
            'Berkuda',
            'Bisbol - Sofbol',
            'Bola Basket',
            'Bola Tangan',
            'Bola Voli',
            'Bulutangkis',
            'Dayung',
            'Golf',
            'Gulat',
            'Hoki',
            'Hoki Es',
            'Judo',
            'Kano',
            'Karate',
            'Layar',
            'Loncat Indah',
            'Menembak',
            'Panahan',
            'Pancalomba Modern',
            'Panjat Tebing',
            'Polo Air',
            'Renang',
            'Renang Indah',
            'Renang Maraton',
            'Rugby',
            'Selancar Ombak',
            'Senam',
            'Sepak Bola',
            'Skateboard',
            'Taekwondo',
            'Tenis',
            'Tenis Meja',
            'Tinju',
            'Triathlon',
        ];

        $nonOlympicSports = [
            'Aero Sport',
            'Billiard',
            'Bowling',
            'Breakdancing',
            'Bridge',
            'Catur',
            'Cricket',
            'Dansa',
            'Dragon Boat',
            'Esport',
            'Floorball',
            'Gateball',
            'Jetski',
            'Jujitsu',
            'Kabaddi',
            'Kempo',
            'Kick Boxing',
            'Korfball',
            'Kurash',
            'Motor',
            'Muay Thai',
            'Pencak Silat',
            'Petanque',
            'Rugby Sevens',
            'Sambo',
            'Sepak Takraw',
            'Sepatu Roda',
            'Soft Tennis',
            'Squash',
            'Wakeboarding',
            'Woodball',
            'Wushu',
        ];

        // Cabor yang biasanya butuh banyak orang (biar keliatan kayak tim)
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

        // Ambil cabor yang SUDAH ada atletnya di DB sekarang
        $existingSports = Athlete::pluck('sport')->unique()->all();

        // Cari athlete_id terbesar sekarang, misal "ATH0010"
        $lastAthleteId = Athlete::max('athlete_id'); // bisa null kalau tabel kosong
        $counter = $lastAthleteId
            ? (int) substr($lastAthleteId, 3)
            : 0;

        // Helper kecil buat generate tanggal lahir
        $makeBirthdate = function (int $index): string {
            $year  = 1995 + ($index % 10);        // 1995–2004
            $month = ($index % 12) + 1;          // 1–12
            $day   = ($index % 28) + 1;          // 1–28

            return Carbon::create($year, $month, $day)->toDateString();
        };

        // === Isi cabor Olympic yang belum punya atlet ===
        foreach ($olympicSports as $sport) {
            if (in_array($sport, $existingSports, true)) {
                // Sudah ada minimal satu atlet untuk cabor ini → skip
                continue;
            }

            $isTeam = in_array($sport, $teamSports, true);
            $athleteCount = $isTeam ? 4 : 1; // tim isi 4 orang, individu 1 orang

            for ($i = 1; $i <= $athleteCount; $i++) {
                $counter++;

                $athleteId = 'ATH' . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);

                Athlete::create([
                    'athlete_id'      => $athleteId,
                    'name'            => "Atlet {$sport} {$i}",
                    'sport_category'  => 'olympic',
                    'sport'           => $sport,
                    'birthdate'       => $makeBirthdate($counter),
                    'gender'          => $counter % 2 === 0 ? 'female' : 'male',
                    'height'          => 160 + ($counter % 25), // 160–184 cm
                    'weight'          => 50 + ($counter % 20),  // 50–69 kg
                    'contact'         => '08' . str_pad((string) $counter, 9, '0', STR_PAD_LEFT),
                    'status'          => 'not_screened',
                ]);
            }
        }

        // === Isi cabor Non-Olympic yang belum punya atlet ===
        foreach ($nonOlympicSports as $sport) {
            if (in_array($sport, $existingSports, true)) {
                continue;
            }

            $isTeam = in_array($sport, $teamSports, true);
            $athleteCount = $isTeam ? 4 : 1;

            for ($i = 1; $i <= $athleteCount; $i++) {
                $counter++;

                $athleteId = 'ATH' . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);

                Athlete::create([
                    'athlete_id'      => $athleteId,
                    'name'            => "Atlet {$sport} {$i}",
                    'sport_category'  => 'non_olympic',
                    'sport'           => $sport,
                    'birthdate'       => $makeBirthdate($counter),
                    'gender'          => $counter % 2 === 0 ? 'female' : 'male',
                    'height'          => 160 + ($counter % 25),
                    'weight'          => 50 + ($counter % 20),
                    'contact'         => '08' . str_pad((string) $counter, 9, '0', STR_PAD_LEFT),
                    'status'          => 'not_screened',
                ]);
            }
        }
    }
}
