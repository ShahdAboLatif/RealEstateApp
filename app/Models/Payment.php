<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // These will be appended to JSON responses
    protected $appends = ['left_to_pay', 'status'];

    protected $fillable = [
        'unit_id',
        'date',
        'owes',
        'paid',
        'notes',
        'reversed_payments',
        'permanent',
        'archived',
    ];

    protected $casts = [
        'date' => 'date',
        'owes' => 'decimal:2',
        'paid' => 'decimal:2',
        'archived' => 'boolean',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Calculate left_to_pay based on owes and paid values
     */
    public function getLeftToPayAttribute(): float
    {
        $owes = (float) ($this->owes ?? 0);
        $paid = (float) ($this->paid ?? 0);

        return max(0, $owes - $paid); // Ensure non-negative value
    }

    /**
     * Calculate status based on left_to_pay and owes values
     */
    public function getStatusAttribute(): string
    {
        $leftToPay = $this->left_to_pay;
        $owes = (float) ($this->owes ?? 0);

        if ($owes == 0) {
            return 'pending'; // No amount owed
        } elseif ($leftToPay == 0) {
            return 'paid';
        } elseif ($leftToPay == $owes) {
            return 'not paid'; // Changed from 'not paid' to match your enum values
        } else {
            return 'paid partly';
        }
    }

    /**
     * Get formatted owes amount
     */
    public function getFormattedOwesAttribute(): string
    {
        return '$' . number_format((float) ($this->owes ?? 0), 2);
    }

    /**
     * Get formatted paid amount
     */
    public function getFormattedPaidAttribute(): string
    {
        return '$' . number_format((float) ($this->paid ?? 0), 2);
    }

    /**
     * Get formatted left_to_pay amount
     */
    public function getFormattedLeftToPayAttribute(): string
    {
        return '$' . number_format($this->left_to_pay, 2);
    }
}
