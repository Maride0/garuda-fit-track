<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Athlete;
use App\Models\TrainingProgram;
use App\Models\TestRecord;

// ganti ini kalau model metrics kamu namanya beda:
use App\Models\PerformanceMetric;

class TestRecordSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel ada
        if (! Schema::hasTable('test_records')) return;

        $athletes = Athlete::query()->orderBy('athlete_id')->get();
        if ($athletes->isEmpty()) return;

        $metrics = PerformanceMetric::query()->get();
        if ($metrics->isEmpty()) return;

        foreach ($athletes as $athlete) {
            // program yg sesuai sport (ambil yang active dulu, kalau kosong ambil yang weekly)
            $program = TrainingProgram::query()
                ->where('sport', $athlete->sport)
                ->orderByRaw("CASE status WHEN 'active' THEN 0 WHEN 'draft' THEN 1 ELSE 2 END")
                ->orderByRaw("CASE type WHEN 'weekly' THEN 0 WHEN 'pre_competition' THEN 1 ELSE 2 END")
                ->orderBy('start_date')
                ->first();

            // Kalau belum ada programnya, skip test record untuk atlet ini
            if (! $program) continue;

            // Pilih metrics yang “relevan”
            // - kalau metrics punya kolom sport, filter by sport
            // - kalau nggak ada, ambil subset “umum” berdasarkan parameter/unit (biar tidak liar)
            $pickedMetrics = $this->pickMetricsForAthlete($metrics, $athlete->sport);

            // Tentukan tanggal phase berdasarkan program
            $start = Carbon::parse($program->start_date)->startOfDay();
            $end   = $program->end_date ? Carbon::parse($program->end_date)->startOfDay() : $start->copy()->addWeeks(6);

            $baseline = $start->copy();
            $pre      = $start->copy()->addDays(7);
            $mid      = $start->copy()->addDays(21);
            $post     = $end->copy()->subDays(1);

            // safety: kalau post < mid, rapihin
            if ($post->lt($mid)) $post = $mid->copy()->addDays(7);

            $phases = [
                'baseline' => $baseline,
                'pre'      => $pre,
                'mid'      => $mid,
                'post'     => $post,
            ];

            foreach ($pickedMetrics as $metric) {
                foreach ($phases as $phase => $date) {
                    $param = $this->getMetricParameter($metric);
                    $unit  = $this->getMetricUnit($metric);

                    // Generate nilai deterministik (bukan random) dari athlete_id + metric_id + phase
                    $value = $this->generateValue(
                        athleteId: (string) $athlete->athlete_id,
                        metricId:  (string) ($metric->metric_id ?? $metric->id),
                        phase:     $phase,
                        parameter: $param,
                        unit:      $unit
                    );

                    // kunci idempotent: athlete + metric + test_date + phase (+ program)
                    TestRecord::updateOrCreate(
                        [
                            'athlete_id' => $athlete->athlete_id,
                            'metric_id'  => $metric->metric_id ?? $metric->id,
                            'test_date'  => $date->toDateString(),
                            'phase'      => $phase,
                        ],
                        [
                            'training_program_id' => $program->training_program_id ?? $program->id,
                            'value'               => $value,
                            'unit'                => $unit, // kalau null, UI kamu akan fallback ke default_unit metric
                            'source'              => 'field_test',
                            'notes'               => $this->makeNotes($athlete->sport, $phase, $param, $unit),
                        ]
                    );
                }
            }
        }
    }

    private function pickMetricsForAthlete($allMetrics, string $sport)
    {
        // kalau metrics punya kolom sport, filter beneran by sport
        $hasSportColumn = Schema::hasColumn($allMetrics->first()->getTable(), 'sport');

        if ($hasSportColumn) {
            $filtered = $allMetrics->where('sport', $sport);
            if ($filtered->count() >= 3) return $filtered->take(4); // cukup 3-4 metric biar tabel RM gak “rame kebangetan”
        }

        // fallback: pilih metric “umum” berdasarkan unit/parameter (biar masuk akal)
        $candidates = $allMetrics->filter(function ($m) {
            $param = strtolower((string) $this->getMetricParameter($m));
            $unit  = strtolower((string) $this->getMetricUnit($m));

            return str_contains($param, 'time')
                || str_contains($param, 'duration')
                || str_contains($param, 'speed')
                || str_contains($param, 'distance')
                || str_contains($param, 'power')
                || str_contains($param, 'strength')
                || str_contains($param, 'heart')
                || in_array($unit, ['s','sec','second','seconds','ms','min','minute','minutes','m','meter','meters','km','kg','bpm','reps','rep'], true);
        });

        // kalau masih kosong, ambil 3 metric pertama aja (terpaksa)
        if ($candidates->isEmpty()) return $allMetrics->take(3);

        return $candidates->take(4);
    }

    private function getMetricParameter($metric): ?string
    {
        foreach (['parameter', 'metric_parameter', 'value_type', 'data_type', 'type', 'category'] as $field) {
            if (isset($metric->{$field}) && filled($metric->{$field})) {
                return (string) $metric->{$field};
            }
        }

        // fallback dari name kalau ada keyword
        $name = strtolower((string) ($metric->name ?? ''));
        if (str_contains($name, 'waktu') || str_contains($name, 'time')) return 'time';
        if (str_contains($name, 'jarak') || str_contains($name, 'distance')) return 'distance';
        if (str_contains($name, 'beban') || str_contains($name, 'kg') || str_contains($name, 'strength')) return 'weight';
        if (str_contains($name, 'denyut') || str_contains($name, 'heart')) return 'heart_rate';

        return null;
    }

    private function getMetricUnit($metric): ?string
    {
        foreach (['default_unit', 'unit'] as $field) {
            if (isset($metric->{$field}) && filled($metric->{$field})) {
                return (string) $metric->{$field};
            }
        }
        return null;
    }

    private function generateValue(
        string $athleteId,
        string $metricId,
        string $phase,
        ?string $parameter,
        ?string $unit
    ): float|int {
        $seed = crc32($athleteId . '|' . $metricId . '|' . $phase);
        $p = strtolower((string) $parameter);
        $u = strtolower((string) $unit);

        // progress kecil dari baseline->post biar “masuk akal”
        $phaseFactor = match ($phase) {
            'baseline' => 1.00,
            'pre'      => 0.98,
            'mid'      => 0.96,
            'post'     => 0.94,
            default    => 1.00,
        };

        // TIME / DURATION (lebih kecil = lebih baik)
        if (str_contains($p, 'time') || str_contains($p, 'duration') || in_array($u, ['s','sec','second','seconds','ms','min','minute','minutes'], true)) {
            // base 10–20 detik atau 1–5 menit tergantung unit
            if (in_array($u, ['min','minute','minutes'], true)) {
                $base = 3.5 + (($seed % 90) / 100); // 3.50–4.39 menit
                $val  = $base * $phaseFactor;
                return round($val, 2);
            }

            // seconds
            $base = 12.0 + (($seed % 900) / 100); // 12.00–20.99 detik
            $val  = $base * $phaseFactor;
            return round($val, 2);
        }

        // DISTANCE (lebih besar = lebih baik)
        if (str_contains($p, 'distance') || in_array($u, ['m','meter','meters','km'], true)) {
            $phaseUp = match ($phase) {
                'baseline' => 1.00,
                'pre'      => 1.02,
                'mid'      => 1.04,
                'post'     => 1.06,
                default    => 1.00,
            };

            if ($u === 'km') {
                $base = 1.2 + (($seed % 80) / 100); // 1.20–1.99 km
                return round($base * $phaseUp, 2);
            }

            $base = 800 + ($seed % 700); // 800–1499 m
            return (int) round($base * $phaseUp);
        }

        // WEIGHT / STRENGTH (kg) (lebih besar = lebih baik)
        if (str_contains($p, 'weight') || str_contains($p, 'strength') || in_array($u, ['kg'], true)) {
            $phaseUp = match ($phase) {
                'baseline' => 1.00,
                'pre'      => 1.03,
                'mid'      => 1.06,
                'post'     => 1.09,
                default    => 1.00,
            };

            $base = 40 + ($seed % 41); // 40–80 kg
            return (int) round($base * $phaseUp);
        }

        // HEART RATE (bpm) (biasanya makin stabil/lebih rendah saat recovery, tapi untuk tes bisa naik.
        // Untuk showcase, kita bikin "resting HR" turun perlahan.
        if (str_contains($p, 'heart') || in_array($u, ['bpm'], true)) {
            $base = 78 + ($seed % 18); // 78–95
            $val  = $base * $phaseFactor; // turun sedikit
            return (int) round($val);
        }

        // REPS / SCORE (lebih besar = lebih baik)
        if (str_contains($p, 'rep') || in_array($u, ['reps','rep'], true) || str_contains($p, 'score')) {
            $phaseUp = match ($phase) {
                'baseline' => 1.00,
                'pre'      => 1.05,
                'mid'      => 1.10,
                'post'     => 1.15,
                default    => 1.00,
            };

            $base = 10 + ($seed % 21); // 10–30
            return (int) round($base * $phaseUp);
        }

        // fallback paling netral: nilai skala 1–10 (TAPI ini last resort)
        $base = 6 + (($seed % 41) / 10); // 6.0–10.0
        return round($base, 1);
    }

    private function makeNotes(string $sport, string $phase, ?string $param, ?string $unit): string
    {
        $p = $param ? "Parameter: {$param}" : "Parameter: (auto)";
        $u = $unit ? "Unit: {$unit}" : "Unit: default metric";
        return "{$sport} — {$phase}\n{$p}\n{$u}\nSumber: field test (seeding showcase).";
    }
}
