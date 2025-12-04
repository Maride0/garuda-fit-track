<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerformanceMetric extends Model
{
    protected $table = 'performance_metrics';

    protected $primaryKey = 'metric_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'metric_id',
        'name',
        'code',
        'sport_category',
        'sport',
        'default_unit',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function performances(): HasMany
    {
        return $this->hasMany(AthletePerformance::class, 'metric_id', 'metric_id');
    }

    /**
     * Unit yang dipake, fallback ke default_unit kalau nggak ada override.
     */
    public function getDisplayUnitAttribute(): ?string
    {
        return $this->default_unit;
    }
}
