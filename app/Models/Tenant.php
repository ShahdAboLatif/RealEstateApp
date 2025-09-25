<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'first_name',
        'last_name',
        'street_address_line',
        'login_email',
        'alternate_email',
        'mobile',
        'emergency_phone',
        'cash_or_check',
        'has_insurance',
        'sensitive_communication',
        'has_assistance',
        'assistance_amount',
        'assistance_company',
        'archived',
    ];

    protected $casts = [
        'assistance_amount' => 'decimal:2',
        'has_insurance' => 'boolean',
        'sensitive_communication' => 'boolean',
        'has_assistance' => 'boolean',
        'archived' => 'boolean',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
