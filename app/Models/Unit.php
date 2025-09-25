<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'street_address_line',
        'count_beds',
        'count_baths',
        'monthly_rent',
        'recurring_transaction',
        'utility_status',
        'account_number',
        'vacant',
        'listed',
        'archived',
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
        'count_beds' => 'decimal:2',
        'count_baths' => 'decimal:2',
        'vacant' => 'boolean',
        'listed' => 'boolean',
        'archived' => 'boolean',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'property_id');
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'unit_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'unit_id');
    }

    public function moveIns()
    {
        return $this->hasMany(MoveIn::class, 'unit_id');
    }

    public function moveOuts()
    {
        return $this->hasMany(MoveOut::class, 'unit_id');
    }

    public function noticeAndEvictions()
    {
        return $this->hasMany(NoticeAndEviction::class, 'unit_id');
    }

    public function vendorTaskTrackers()
    {
        return $this->hasMany(VendorTaskTracker::class, 'unit_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'unit_id');
    }

    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class, 'unit_id');
    }

    public function offersAndRenewals()
    {
        return $this->hasMany(OffersAndRenewal::class, 'unit_id');
    }

    // Calculated properties
    public function getTotalApplicationsAttribute(): int
    {
        return $this->applications()->where('archived',false)->count();
    }

    public function getCurrentTenantAttribute()
    {
        return $this->tenants()->where('archived', false)->first();
    }

    public function getFormattedMonthlyRentAttribute(): string
    {
        return $this->monthly_rent
        ? '$' . number_format((float) $this->monthly_rent, 2)
        : 'N/A';
    }

    public function getFullAddressAttribute(): string
    {
        return $this->street_address_line . ', ' . $this->property->city->name;
    }
}
