<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
class PropertyInfo extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'city_id',
        'name',
        'archived'
    ];

      protected $casts = [
        'archived' => 'boolean',
        'city_id' => 'integer',
    ];

    // Check if record is archived
    public function isArchived(): bool  // ← ADDED this entire method
    {
        return $this->archived;
    }
    // Relationships
    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'property_id');
    }

    public function propertyInsurances()
    {
        return $this->hasOne(PropertyInsurance::class, 'property_id');
    }

    // Calculated properties
    public function getTotalUnitsAttribute(): int
    {
        return $this->units()->count();
    }

    public function getVacantUnitsAttribute(): int
    {
        return $this->units()->where('vacant', true)->count();
    }

    public function getOccupiedUnitsAttribute(): int
    {
        return $this->units()->where('vacant', false)->count();
    }

    public function getListedUnitsAttribute(): int
    {
        return $this->units()->where('listed', true)->count();
    }

    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('archived', false);
        });
    }

    // Scope to include archived records
    public function scopeWithArchived(Builder $query): Builder
    {
        return $query->withoutGlobalScope('active');
    }

    // Scope to get only archived records
    public function scopeOnlyArchived(Builder $query): Builder
    {
        return $query->withoutGlobalScope('active')->where('archived', true);
    }
}
