<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestRecord extends Model
{
    protected $table = 'test_records';

    protected $fillable = [
        'athlete_id',
        'metric_id',
        'training_program_id',
        'test_date',
        'phase',
        'value',
        'unit',
        'source',
        'notes',
    ];

    protected $casts = [
        'test_date' => 'date',
        'value'     => 'decimal:2',
    ];

    public function athlete(): BelongsTo
    {
        // PK di athletes = athlete_id (string)
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    public function metric(): BelongsTo
    {
        return $this->belongsTo(PerformanceMetric::class, 'metric_id', 'id');
    }

    public function trainingProgram(): BelongsTo
    {
        // PK di training_programs = program_id (string)
        return $this->belongsTo(TrainingProgram::class, 'training_program_id', 'program_id');
    }

    /**
     * Unit yang dipakai untuk tampilan:
     * - kalau kolom unit di record ada → pakai itu
     * - kalau kosong → fallback ke default_unit di metric
     */
    public function getDisplayUnitAttribute(): ?string
    {
        if ($this->unit) {
            return $this->unit;
        }

        return $this->metric?->default_unit;
    }
        protected function afterSave(): void
    {
        $evaluation = $this->record;

        // Metric optional → kalau kosong, jangan bikin test record
        if (! $evaluation->metric_id) {
            return;
        }

        // Kalau dua-duanya kosong, skip
        if (
            $evaluation->metric_numeric_value === null &&
            blank($evaluation->metric_text_value)
        ) {
            return;
        }

        TestRecord::updateOrCreate(
            [
                'source_type' => 'program_evaluation',
                'source_id'   => $evaluation->id,
            ],
            [
                'athlete_id' => $evaluation->athlete_id,
                'program_id' => $evaluation->training_program_id,
                'metric_id'  => $evaluation->metric_id,
                'test_date'  => $evaluation->evaluation_date,
                'phase'      => 'program_evaluation',
                'source'     => 'Program Evaluation',

                // pilih sesuai struktur kolom kamu
                'value_numeric' => $evaluation->metric_numeric_value,
                'value_text'    => $evaluation->metric_text_value,
            ]
        );
    }
    public function program()
    {
        return $this->belongsTo(
            TrainingProgram::class,
            'training_program_id',
            'program_id'
        );
    }

}
