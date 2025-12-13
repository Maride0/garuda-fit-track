<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Athlete;
use App\Models\TrainingProgram;
use App\Models\PerformanceMetric;
use App\Models\TestRecord;

class PerformanceEvaluation extends Model
{
    protected $table = 'performance_evaluations';

    protected $fillable = [
        'athlete_id',
        'training_program_id',
        'evaluation_date',
        'overall_rating',
        'discipline_score',
        'attendance_score',
        'effort_score',
        'attitude_score',
        'tactical_understanding_score',
        'coach_notes',
        'created_by',
        'metric_id',
        'value_numeric',
        'value_label',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    // ==========================
    // RELATIONS
    // ==========================

    public function athlete(): BelongsTo
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id', 'program_id');
    }

    public function metric(): BelongsTo
    {
        return $this->belongsTo(PerformanceMetric::class, 'metric_id', 'id');
    }

    public function creator(): BelongsTo
    {
        // kalau nanti kamu punya User model buat coach
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==========================
    // ACCESSORS / HELPERS
    // ==========================

    public function getDisplayValueAttribute(): ?string
    {
        if (! is_null($this->value_numeric)) {
            return (string) $this->value_numeric;
        }

        return $this->value_label;
    }

    public function getAverageSubScoreAttribute(): ?float
    {
        $scores = [
            $this->discipline_score,
            $this->attendance_score,
            $this->effort_score,
            $this->attitude_score,
            $this->tactical_understanding_score,
        ];

        $scores = array_filter($scores, fn ($v) => ! is_null($v));

        if (empty($scores)) {
            return null;
        }

        return round(array_sum($scores) / count($scores), 2);
    }
    protected static function booted(): void
        {
            static::deleting(function (self $evaluation) {
                // 1) hapus yg udah rapi (punya source tracking)
                TestRecord::where('source_type', 'program_evaluation')
                    ->where('source_id', (string) $evaluation->id)
                    ->delete();

                // 2) fallback: hapus orphan yg match atribut (optional)
                TestRecord::whereNull('source_type')
                    ->whereNull('source_id')
                    ->where('athlete_id', $evaluation->athlete_id)
                    ->where('training_program_id', $evaluation->training_program_id)
                    ->where('metric_id', $evaluation->metric_id)
                    ->whereDate('test_date', $evaluation->evaluation_date)
                    ->delete();
            });
        }
}
