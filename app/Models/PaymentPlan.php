<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'amount',
        'dates',
        'paid',
        'notes',
        'archived',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid' => 'decimal:2',
        'dates' => 'date',
        'archived' => 'boolean',
    ];

    protected $appends = ['left_to_pay', 'status'];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getLeftToPayAttribute()
    {
        return $this->amount - $this->paid;
    }

    public function getStatusAttribute()
    {
        $leftToPay = $this->left_to_pay;

        if ($leftToPay == 0) {
            return 'paid';
        } elseif ($leftToPay == $this->amount) {
            return 'not paid';
        } elseif ($leftToPay > 0 && $leftToPay < $this->amount) {
            return 'paid partly';
        } else {
            return 'N/A';
        }
    }
}
