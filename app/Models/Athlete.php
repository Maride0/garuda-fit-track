<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use App\Models\TrainingProgram;
use Illuminate\Support\Facades\Storage;

class Athlete extends Model
{
    use HasFactory;

    // Tabel dan primary key
    protected $table = 'athletes';          // sebenernya default, tapi eksplisit itu enak
    protected $primaryKey = 'athlete_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignment
    protected $fillable = [
        'athlete_id',
        'avatar',
        'name',
        'gender',
        'birthdate',
        'contact',
        'sport_category',
        'sport',
        'height',
        'weight',
        'status',
        'last_screening_date',
        'next_screening_due',
    ];

    // Casting tipe data
    protected $casts = [
        'birthdate' => 'date',
        'height'    => 'float',
        'weight'    => 'float',
        'last_screening_date' => 'date',
        'next_screening_due'  => 'date',
    ];

    // Relasi ke Achievement (buat Relation Manager nanti)
    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'athlete_id', 'athlete_id');
    }

    // Summary medali (accessor)
    public function getMedalsSummaryAttribute(): string
    {
        $counts = $this->achievements()
            ->selectRaw('medal_rank, COUNT(*) as total')
            ->whereIn('medal_rank', ['gold', 'silver', 'bronze'])
            ->groupBy('medal_rank')
            ->pluck('total', 'medal_rank');

        $labels = [
            'gold'   => 'Gold',
            'silver' => 'Silver',
            'bronze' => 'Bronze',
        ];

        $parts = [];

        foreach ($labels as $key => $label) {
            if (! empty($counts[$key])) {
                $parts[] = "{$counts[$key]}× {$label}";
            }
        }

        return $parts ? implode(', ', $parts) : '-';
    }

    // Relasi ke HealthScreening dan TherapySchedule
    public function healthScreenings()
    {
        return $this->hasMany(HealthScreening::class, 'athlete_id', 'athlete_id');
    }
    public function therapySchedules()
    {
        return $this->hasMany(TherapySchedule::class, 'athlete_id', 'athlete_id');
    }

    /**
     * Hitung ulang status, last_screening_date, dan next_screening_due
     */
    public function recalculateStatus(): void
    {
        // 1. Ambil screening terbaru
        $latestScreening = $this->healthScreenings()
            ->orderByDesc('screening_date')
            ->orderByDesc('created_at')
            ->first();

        // Kalau belum pernah screening sama sekali
        if (! $latestScreening) {
            $this->status              = 'not_screened';
            $this->last_screening_date = null;
            $this->next_screening_due  = null;
            $this->save();

            return;
        }

        // 2. Cari terapi aktif (planned / active)
        $activeTherapy = $this->therapySchedules()
            ->whereIn('status', ['planned', 'active'])
            ->orderByDesc('start_date')
            ->first();

        $hasActiveTherapy = (bool) $activeTherapy;

        // 3. Set tanggal screening terakhir
        $this->last_screening_date = $latestScreening->screening_date;

        // 4. Default next screening = 6 bulan dari screening terakhir
        $defaultNext = $this->last_screening_date
            ? Carbon::parse($this->last_screening_date)->addMonths(6)
            : null;

        $nextScreening = $defaultNext;

        // 5. Kalau lagi terapi aktif & frequency diisi → override pakai interval minggu
        if ($activeTherapy && $activeTherapy->frequency) {
            $nextScreening = $this->last_screening_date
                ? Carbon::parse($this->last_screening_date)->addWeeks($activeTherapy->frequency)
                : $defaultNext;
        }

        $this->next_screening_due = $nextScreening;

        // 6. Mapping hasil screening → status atlet
        $result = $latestScreening->screening_result; // 'fit' / 'restricted' / 'requires_therapy'

        if ($result === 'fit') {
            $this->status = 'fit';

        } elseif ($result === 'restricted') {
            $this->status = 'restricted';

        } elseif ($result === 'requires_therapy') {
            if ($hasActiveTherapy) {
                $this->status = 'active_therapy';
            } else {
                $this->status = 'under_monitoring';
            }

        } else {
            // fallback defensif
            $this->status = $this->status ?? 'not_screened';
        }

        // 7. Simpan semua perubahan
        $this->save();
    }

    /**
     * Cek apakah screening berikutnya sudah jatuh tempo / terlewat
     */

    public function isScreeningDue(): bool
    {
        if (! $this->next_screening_due) {
            return false;
        }

        return now()->toDateString() >= $this->next_screening_due->toDateString();
    }

    public function isScreeningOverdue(): bool
    {
        if (! $this->next_screening_due) {
            return false;
        }

        $overdueDate = $this->next_screening_due->copy()->addMonth();

        return now()->greaterThan($overdueDate);
    }
        protected function age(): Attribute
    {
        return Attribute::get(
            fn () => $this->birthdate
                ? Carbon::parse($this->birthdate)->age
                : null
        );
    }
     public function trainingPrograms(): BelongsToMany
    {
        return $this->belongsToMany(
            TrainingProgram::class,
            'athlete_training_program', // ganti kalau nama pivot-mu beda
            'athlete_id',               // FK ke tabel athletes
            'program_id',               // FK ke tabel training_programs (PK string)
        )
        ->withPivot('join_date')
        ->withTimestamps();
    }
    public function testRecords()
    {
        return $this->hasMany(TestRecord::class, 'athlete_id', 'athlete_id');
    }

    public function performanceEvaluations()
    {
        return $this->hasMany(PerformanceEvaluation::class, 'athlete_id', 'athlete_id');
    }
    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        if (Storage::disk('public')->exists($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }

        return null;
    }


}