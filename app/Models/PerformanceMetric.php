<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerformanceMetric extends Model
{
    protected $table = 'performance_metrics';

    // ✅ pakai primary key default: "id"
    // jadi yang ini semua DIHAPUS:
    // protected $primaryKey = 'metric_id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
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

    public function testRecords(): HasMany
    {
        // FK di tabel test_records = metric_id
        // PK di performance_metrics = id
        return $this->hasMany(TestRecord::class, 'metric_id', 'id');
    }

    /**
     * Unit yang dipake, fallback ke default_unit kalau nggak ada override.
     */
    public function getDisplayUnitAttribute(): ?string
    {
        return $this->default_unit;
    }
}
