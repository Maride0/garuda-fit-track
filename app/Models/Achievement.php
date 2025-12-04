<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';

    protected $primaryKey = 'achievement_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'achievement_id',
        'athlete_id',

        // Section 2
        'achievement_name',
        'event_number',
        'notes',
        'evidence_file',

        // Section 2
        'medal_rank',
        'rank',
        'result',

        // Section 3
        'event_name',
        'competition_level',
        'organizer',
        'start_date',
        'end_date',
        'location',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'rank'       => 'integer',
    ];

    protected static function booted(): void
{
    static::creating(function (Achievement $achievement) {
        // Generate ID kalau belum ada
        if (blank($achievement->achievement_id)) {
            $achievement->achievement_id = static::generateNextId();
        }
    });

    static::saving(function (Achievement $achievement) {
        // Auto-set rank berdasarkan medal_rank kalau rank belum diisi
        if (in_array($achievement->medal_rank, ['gold', 'silver', 'bronze'], true)) {
            if (blank($achievement->rank)) {
                $achievement->rank = match ($achievement->medal_rank) {
                    'gold'   => 1,
                    'silver' => 2,
                    'bronze' => 3,
                    default  => null,
                };
            }
        }

        // Non-podium: boleh null atau diisi manual, jangan diutak-atik
        if ($achievement->medal_rank === 'non_podium' && blank($achievement->rank)) {
            $achievement->rank = null;
        }
    });
}
public function athlete()
{
    return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
}

public static function generateNextId(): string
{
    $lastId = static::query()
        ->where('achievement_id', 'like', 'ACH%')
        ->orderBy('achievement_id', 'desc')
        ->value('achievement_id');

    if ($lastId) {
        $num = (int) substr($lastId, 3) + 1;
    } else {
        $num = 1;
    }

    return 'ACH' . str_pad((string) $num, 4, '0', STR_PAD_LEFT);
}


}