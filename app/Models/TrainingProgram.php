<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\TrainingSession;
use App\Models\Athlete;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $primaryKey = 'program_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'program_id',
        'name',
        'type',
        'intensity',
        'sport_category',
        'sport',
        'team_name',
        'coach_name',
        'start_date',
        'end_date',
        'planned_sessions',
        'goal',
        'status',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'end_date'         => 'date',
        'planned_sessions' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helper: Generate ID berikutnya (TPR0001, TPR0002, ...)
    |--------------------------------------------------------------------------
    */
    public static function generateNextId(): string
    {
        $lastId = static::query()
            ->where('program_id', 'like', 'TPR%')
            ->orderBy('program_id', 'desc')
            ->value('program_id');

        if ($lastId) {
            $number = (int) substr($lastId, 3); // ambil setelah "TPR"
        } else {
            $number = 0;
        }

        $nextNumber = $number + 1;

        return 'TPR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /*
    |--------------------------------------------------------------------------
    | BOOT: Auto-generate program_id kalau belum ada
    |--------------------------------------------------------------------------
    */
    protected static function booted(): void
    {
        static::creating(function (TrainingProgram $program) {
            if (! $program->program_id) {
                $program->program_id = static::generateNextId();
            }
        });
    }

    // ───────────── RELATIONS ─────────────

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class, 'program_id', 'program_id');
    }

    public function athletes()
    {
        return $this->belongsToMany(
                Athlete::class,
                'athlete_training_program',
                'program_id',
                'athlete_id',
                'program_id',
            )
            ->withPivot(['status', 'role', 'join_date'])
            ->withTimestamps();
    }

    // ───────────── ACCESSORS ─────────────

    public function getCompletedSessionsCountAttribute(): int
    {
        return $this->sessions()
            ->where('status', 'completed')
            ->count();
    }

    public function getProgressPercentAttribute(): ?int
    {
        if (! $this->planned_sessions || $this->planned_sessions == 0) {
            return null;
        }

        $completed = $this->completed_sessions_count;

        return (int) floor(($completed / $this->planned_sessions) * 100);
    }

    // ───────────── SCOPES ─────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCurrent($query)
    {
        return $query
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }
    public function performances()
    {
        return $this->hasMany(AthletePerformance::class, 'training_program_id', 'program_id');
    }

    public function performanceEvaluations()
    {
        return $this->hasMany(PerformanceEvaluation::class, 'training_program_id', 'program_id');
    }
}
