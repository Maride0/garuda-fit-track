<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingProgram;
use App\Models\TrainingSession;
use Illuminate\Support\Carbon;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        $programs = TrainingProgram::all();

        foreach ($programs as $program) {
            // Pakai planned_sessions sebagai jumlah sesi
            $sessionsCount = $program->planned_sessions ?? 5;

            if ($sessionsCount <= 0) {
                continue;
            }

            $start = Carbon::parse($program->start_date);
            $end   = Carbon::parse($program->end_date);

            // Kalau end_date < start_date (just in case), paksa span minimal
            if ($end->lessThan($start)) {
                $end = (clone $start)->addDays(max($sessionsCount - 1, 0));
            }

            $spanDays = max($start->diffInDays($end), $sessionsCount - 1);
            $step     = $sessionsCount > 1 ? intdiv($spanDays, $sessionsCount - 1) : 0;

            for ($i = 0; $i < $sessionsCount; $i++) {
                $date = (clone $start)->addDays($step * $i);

                // ───── Tentukan status sesi berdasarkan status program ─────
                $status        = 'scheduled';
                $cancelReason  = null;

                switch ($program->status) {
                    case 'completed':
                        $status = 'completed';
                        break;

                    case 'draft':
                        $status = 'scheduled';
                        break;

                    case 'active':
                    default:
                        $status = fake()->randomElement([
                            'scheduled',
                            'on_going',
                            'completed',
                            'cancelled',
                        ]);

                        if ($status === 'cancelled') {
                            $cancelReason = fake()->randomElement([
                                'Hujan deras',
                                'Lapangan dipakai tim lain',
                                'Pelatih berhalangan',
                                'Kondisi atlet tidak memungkinkan',
                            ]);
                        }
                        break;
                }

                // Kalau tidak cancelled, alasan batal harus null
                if ($status !== 'cancelled') {
                    $cancelReason = null;
                }

                TrainingSession::create([
                    'program_id'       => $program->program_id,

                    'date'             => $date->toDateString(),
                    'start_time'       => '08:00',
                    'end_time'         => '10:00',
                    'duration_minutes' => 120,

                    'location'         => fake()->randomElement([
                        'Lapangan Utama',
                        'Gym Indoor',
                        'Lapangan Samping',
                        'Ruang Latihan Fisik',
                    ]),

                    'activities_notes' => fake()->sentence(10),

                    'status'           => $status,
                    'cancel_reason'    => $cancelReason,
                ]);
            }
        }
    }
}
