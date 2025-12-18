<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingProgram;
use App\Models\TrainingSession;
use Carbon\Carbon;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        // === Sesuaikan kalau FK kamu beda nama ===
        $programForeignKey = 'program_id';

        // Mulai dari minggu depan (Senin)
        $start = Carbon::now()->addWeek()->startOfWeek(Carbon::MONDAY);

        // Range 1 bulan ke depan dari start
        $end = $start->copy()->addMonth()->endOfDay();

        // Pola latihan: 2x seminggu (Selasa & Kamis)
        $daysOfWeek = [
            Carbon::TUESDAY,
            Carbon::THURSDAY,
        ];

        $programs = TrainingProgram::query()
            ->orderBy('sport')
            ->orderBy('start_date')
            ->get();

        if ($programs->isEmpty()) {
            return;
        }

        foreach ($programs as $idx => $program) {
            // Ambil primary key program yang benar (id/program_id/training_program_id, dll)
            $programPk = $program->getKey();

            // Guard biar gak ada FK null
            if (! $programPk) {
                continue;
            }

            // Variasi jam biar gak semua sama persis (07:00 / 15:30 / 18:00 muter)
            [$startTime, $duration] = $this->pickTimeAndDuration($program, $idx);

            $location = $this->pickLocation($program->sport);
            $notes    = $this->buildNotes($program->sport, $program->intensity);

            foreach ($daysOfWeek as $dow) {
                // cari tanggal pertama untuk DOW tsb setelah start
                $cursor = $start->copy()->next($dow);

                while ($cursor->lte($end)) {
                    $date = $cursor->toDateString();

                    $start_time = Carbon::parse($startTime)->format('H:i');
                    $end_time   = Carbon::parse($startTime)->addMinutes($duration)->format('H:i');

                    TrainingSession::updateOrCreate(
                        [
                            $programForeignKey => $programPk,
                            'date'             => $date,
                            'start_time'       => $start_time,
                        ],
                        [
                            'end_time'         => $end_time,
                            'duration_minutes' => $duration,
                            'location'         => $location,
                            'activities_notes' => $notes,
                            'status'           => 'scheduled',
                            'cancel_reason'    => null,
                        ]
                    );

                    $cursor->addWeek();
                }
            }
        }
    }

    private function pickTimeAndDuration($program, int $idx): array
    {
        $timeSlots = ['07:00', '15:30', '18:00'];

        $intensity = $program->intensity ?? 'medium';
        $duration = match ($intensity) {
            'low'    => 60,
            'high'   => 120,
            default  => 90,
        };

        $startTime = $timeSlots[$idx % count($timeSlots)];

        return [$startTime, $duration];
    }

    private function pickLocation(?string $sport): string
    {
        $sport = $sport ?? '';

        $map = [
            'Sepak Bola'   => 'Lapangan Utama',
            'Bola Basket'  => 'GOR Basket',
            'Esport'       => 'Ruang Esports',
            'Panahan'      => 'Lapangan Panahan',
            'Anggar'       => 'Gelanggang Anggar',
            'Tenis Meja'   => 'Ruang Tenis Meja',
            'Berkuda'      => 'Arena Berkuda',
            'Pencak Silat' => 'Dojo / Matras',
            'Muay Thai'    => 'Gym Beladiri',
        ];

        return $map[$sport] ?? 'Fasilitas Latihan';
    }

    private function buildNotes(?string $sport, ?string $intensity): string
    {
        $sport = $sport ?? 'Olahraga';
        $intensity = $intensity ?? 'medium';

        $block = match ($intensity) {
            'low' => "Pemanasan 10-15 menit\nTeknik dasar ringan\nPendinginan & stretching",
            'high' => "Pemanasan dinamis 15 menit\nDrill intensitas tinggi\nSimulasi / sparring\nPendinginan & recovery",
            default => "Pemanasan 10-15 menit\nDrill teknik + fisik\nPendinginan & stretching",
        };

        return "Sesi {$sport} ({$intensity})\n\n{$block}\n\nCatatan: Sesuaikan beban dengan kondisi atlet.";
    }
}
