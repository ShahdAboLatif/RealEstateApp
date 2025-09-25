<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PropertyInsurance extends Model
{
    use HasFactory;

    protected $table = 'property_insurance';
    protected $appends = ['formatted_amount', 'status'];

    protected $fillable = [
        'property_id',
        'insurance_company_name',
        'amount',
        'policy_number',
        'effective_date',
        'expiration_date',
        'archived',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'archived' => 'boolean',
        'effective_date' => 'date',
        'expiration_date' => 'date',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(PropertyInfo::class, 'property_id');
    }

    // Calculated properties
    public function getFormattedAmountAttribute(): string
    {
        if (is_null($this->amount)) {
            return '$0.00';
        }
        return '$' . number_format((float) $this->amount, 2);
    }

    public function getStatusAttribute(): string
    {
        $today = Carbon::now()->startOfDay();
        $expirationDate = Carbon::parse($this->expiration_date)->startOfDay();

        return $today->gte($expirationDate) ? 'expired' : 'active';
    }


}
