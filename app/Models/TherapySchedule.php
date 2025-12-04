<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapySchedule extends Model
{
    use HasFactory;

    protected $table = 'therapy_schedules';

    protected $fillable = [
        'athlete_id',
        'health_screening_id',
        'parent_therapy_schedule_id', // ⬅️ tambahin ini
        'therapy_type',
        'therapist_name',
        'start_date',
        'end_date',
        'frequency',
        'status',
        'progress',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'frequency'  => 'integer',
        'progress'   => 'integer',
    ];

    /**
     * Booted model events
     *
     * Setiap kali jadwal terapi dibuat / diupdate / dihapus,
     * status atlet akan dihitung ulang lewat Athlete::recalculateStatus().
     */
    protected static function booted()
    {
        static::saving(function (TherapySchedule $schedule) {

            // Kalau status completed → progress otomatis 100
            if ($schedule->status === 'completed') {
                $schedule->progress = 100;
            }
        });

        static::saved(function (TherapySchedule $schedule) {
            $athlete = $schedule->athlete;

            if (! $athlete) {
                return;
            }

            // Jalankan recalculation status seperti biasa
            $athlete->recalculateStatus();

            // RULE khusus: completed dan tidak ada therapy active → set under_monitoring
            if ($schedule->status === 'completed') {

                $hasActiveTherapy = $athlete->therapySchedules()
                    ->where('status', 'active')
                    ->exists();

                if (! $hasActiveTherapy && $athlete->status === 'active_therapy') {
                    $athlete->forceFill([
                        'status' => 'under_monitoring',
                    ])->saveQuietly();
                }
            }
        });

        static::deleted(function (TherapySchedule $schedule) {
            $schedule->athlete?->recalculateStatus();
        });
    }


    /**
     * RELATIONS
     */

    // Relasi ke Athlete (PK string)
    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    // Relasi ke Health Screening (optional)
        public function healthScreening()
    {
        return $this->belongsTo(HealthScreening::class, 'health_screening_id', 'screening_id');
    }

    // Terapi induk (kalau ini follow up dari jadwal sebelumnya)
    public function parentSchedule()
    {
        return $this->belongsTo(self::class, 'parent_therapy_schedule_id');
    }

    // Anak-anak follow up dari terapi ini
    public function childFollowUps()
    {
        return $this->hasMany(self::class, 'parent_therapy_schedule_id');
    }

    /**
     * SCOPES
     */

    // Biar enak dipanggil: TherapySchedule::forAthlete($id)->active()->latest()->first()
    public function scopeForAthlete($query, string $athleteId)
    {
        return $query->where('athlete_id', $athleteId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFinal(): bool
    {
        // kalau completed / cancelled dianggap final & harus di-lock
        return in_array($this->status, ['completed', 'cancelled'], true);
    }

    /**
     * Scope tambahan
     */
    public function scopeNotFinal($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled']);
    }
    public function therapySchedule()
    {
        // local key: screening_id  (SCR0001 dst)
        // foreign key di therapy_schedules: health_screening_id
        return $this->hasOne(TherapySchedule::class, 'health_screening_id', 'screening_id');
    }
}
