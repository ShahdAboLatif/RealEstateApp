<?php
// app/Models/VendorInfo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorInfo extends Model
{
    use HasFactory;

    protected $table = 'vendors_info';

    protected $fillable = [
        'city_id',
        'vendor_name',
        'number',
        'email',
        'service_type',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];

    // Relationships
    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function vendorTasks()
    {
        return $this->hasMany(VendorTaskTracker::class, 'vendor_id');
    }

    // Scope for filtering by vendor name
    public function scopeByVendorName($query, $vendorName)
    {
        return $vendorName ? $query->where('vendor_name', 'like', '%' . $vendorName . '%') : $query;
    }

    // Scope for filtering by service type
    public function scopeByServiceType($query, $serviceType)
    {
        return $serviceType ? $query->where('service_type', $serviceType) : $query;
    }

    // Accessor for formatted display name
    public function getDisplayNameAttribute(): string
    {
        return $this->vendor_name . ' (' . $this->city->name . ')';
    }
}
