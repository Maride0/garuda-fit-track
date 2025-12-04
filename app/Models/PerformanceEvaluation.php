<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'overall_rating'  => 'integer',
        'discipline_score' => 'integer',
        'attendance_score' => 'integer',
        'effort_score' => 'integer',
        'attitude_score' => 'integer',
        'tactical_understanding_score' => 'integer',
    ];

    public function athlete(): BelongsTo
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    public function trainingProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id', 'program_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
