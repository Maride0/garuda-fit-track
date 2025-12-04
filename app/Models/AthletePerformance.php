<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AthletePerformance extends Model
{
    protected $table = 'athlete_performances';

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
        return $this->belongsTo(PerformanceMetric::class, 'metric_id', 'metric_id');
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
}
