<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AthleteTrainingProgram extends Model
{
    use HasFactory;

    protected $table = 'athlete_training_program'; // nama tabel pivot

    protected $fillable = [
        'athlete_id',
        'program_id',
        'status',
        'role',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'athlete_id');
    }

    public function program()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id', 'program_id');
    }
    protected static function booted()
    {
        static::creating(function ($pivot) {
            if (! $pivot->join_date) {
                $pivot->join_date = now();
            }
        });
    }

}
