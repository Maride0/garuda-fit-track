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
            // Variasi jam biar gak semua sama persis
            // (07:00 / 15:30 / 18:00 muter)
            [$startTime, $duration] = $this->pickTimeAndDuration($program, $idx);

            $location = $this->pickLocation($program->sport);
            $notes = $this->buildNotes($program->sport, $program->intensity);

            // generate tanggal dalam range start..end untuk dayOfWeek tertentu
            foreach ($daysOfWeek as $dow) {
                $cursor = $start->copy()->next($dow);

                while ($cursor->lte($end)) {
                    $date = $cursor->toDateString();

                    $start_time = Carbon::parse($startTime)->format('H:i');
                    $end_time = Carbon::parse($startTime)->addMinutes($duration)->format('H:i');

                    TrainingSession::updateOrCreate(
                        [
                            'training_program_id' => $program->training_program_id ?? $program->id, // jaga2 kalau pk id custom
                            'date'       => $date,
                            'start_time' => $start_time,
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
        // slot waktu muter biar variatif
        $timeSlots = ['07:00', '15:30', '18:00'];

        // durasi by intensity (kalau null fallback)
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
