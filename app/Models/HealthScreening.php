<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthScreening extends Model
{
    use HasFactory;

    protected $table = 'health_screenings';

    // ✅ Primary key sekarang screening_id (string, non increment)
    protected $primaryKey = 'screening_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'screening_id',
        'auto_increment', // ⬅️ baru

        'athlete_id',
        'follow_up_therapy_schedule_id',

        'screening_date',
        'exam_type',
        'screening_result',

        'blood_pressure',
        'heart_rate',
        'temperature',
        'respiration_rate',
        'oxygen_saturation',

        'chief_complaint',
        'injury_history',
        'pain_location',
        'pain_scale',

        'training_load',
        'training_frequency',

        'notes',

        'is_locked',
        'finalized_at',
        'report_file_path',

    ];

    protected $casts = [
        'screening_date' => 'date',
        'finalized_at'   => 'datetime',
        'is_locked'      => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function (HealthScreening $screening) {
            $screening->athlete?->recalculateStatus();
        });

        static::deleted(function (HealthScreening $screening) {
            $screening->athlete?->recalculateStatus();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    // 1 screening → 1 primary therapy schedule
    public function therapySchedule()
    {
        return $this->hasOne(\App\Models\TherapySchedule::class, 'health_screening_id', 'screening_id');
    }

    // Optional: 1 screening → many therapy schedules
    public function therapySchedules()
    {
        return $this->hasMany(\App\Models\TherapySchedule::class, 'health_screening_id', 'screening_id');
    }

    public function followUpTherapy()
    {
        return $this->belongsTo(\App\Models\TherapySchedule::class, 'follow_up_therapy_schedule_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getDisplayResultAttribute(): string
    {
        $schedule = $this->therapySchedule;

        $hasActiveTherapy = $schedule
            && in_array($schedule->status, ['planned', 'active'], true);

        if (
            $this->screening_result === 'requires_therapy'
            && $hasActiveTherapy
        ) {
            return 'active_therapy';
        }

        return $this->screening_result;
    }

    public function isLocked(): bool
    {
        return (bool) $this->is_locked;
    }
}
