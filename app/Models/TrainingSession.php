<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'date',
        'start_time',
        'end_time',
        'duration_minutes',
        'location',
        'activities_notes',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'date' => 'date',
        // start_time & end_time kita simpan sebagai string "H:i"
        // biar gampang di-handle di accessor
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function program(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id', 'program_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Hitung jam selesai (end_time) secara on the fly dari start_time + duration_minutes
     * kalau end_time di DB masih null.
     */
    public function getEndTimeAttribute($value)
    {
        // Kalau sudah ada di database (diisi manual), pakai itu saja
        if ($value) {
            return $value;
        }

        if (!$this->start_time || !$this->duration_minutes) {
            return null;
        }

        // Bisa jadi start_time itu string "08:00" atau "08:00:00" atau Carbon
        if ($this->start_time instanceof Carbon) {
            $time = $this->start_time->format('H:i:s');
        } else {
            $time = (string) $this->start_time;
        }

        if (strlen($time) === 5) {
            // "08:00"
            $start = Carbon::createFromFormat('H:i', $time);
        } else {
            // "08:00:00"
            $start = Carbon::createFromFormat('H:i:s', $time);
        }

        $end = $start->copy()->addMinutes($this->duration_minutes);

        return $end->format('H:i');
    }

    /**
     * Helper buat tampilin durasi dalam format "60 menit", "90 menit", dst.
     */
    public function getDurationLabelAttribute(): ?string
    {
        if (!$this->duration_minutes) {
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
