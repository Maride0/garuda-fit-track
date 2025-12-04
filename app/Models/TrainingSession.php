<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'date',
        'start_time',
        'duration_minutes',
        'location',
        'participants_count',
        'activities',
        'status',
    ];

    protected $casts = [
        'date'       => 'date',
        'start_time' => 'datetime:H:i',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function program()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id', 'program_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Hitung jam selesai (end_time) secara on the fly dari start_time + duration_minutes.
     */
    public function getEndTimeAttribute(): ?string
    {
        if (! $this->start_time || ! $this->duration_minutes) {
            return null;
        }

        $start = \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time);
        $end   = $start->copy()->addMinutes($this->duration_minutes);

        return $end->format('H:i');
    }

    /**
     * Helper buat tampilin durasi dalam format "60 menit", "90 menit", dst.
     */
    public function getDurationLabelAttribute(): ?string
    {
        if (! $this->duration_minutes) {
            return null;
        }

        return $this->duration_minutes . ' menit';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (buat query di widget / schedule view)
    |--------------------------------------------------------------------------
    */

    // Sesi mendatang (>= hari ini)
    public function scopeUpcoming($query)
    {
        return $query->whereDate('date', '>=', now()->toDateString());
    }

    // Minggu ini
    public function scopeThisWeek($query)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek   = now()->endOfWeek();

        return $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
    }
}
