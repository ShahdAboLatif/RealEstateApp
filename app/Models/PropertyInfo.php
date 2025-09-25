<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyInfo extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'city_id',
        'name',
    ];

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
}
